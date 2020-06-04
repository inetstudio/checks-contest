<?php

namespace InetStudio\ReceiptsContest\Receipts\Console\Commands;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\ModerateCommandContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract as ReceiptsServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract as StatusesServiceContract;

class ModerateCommand extends Command implements ModerateCommandContract
{
    protected $signature = 'inetstudio:receipts-contest:receipts:moderate';

    protected $description = 'Moderate receipts';

    protected ReceiptsServiceContract $receiptsService;

    protected StatusesServiceContract $statusesService;

    protected CarbonInterface $contestStartDate;

    protected CarbonInterface $contestEndDate;

    public function __construct(ReceiptsServiceContract $receiptsService, StatusesServiceContract $statusesService)
    {
        parent::__construct();

        $this->receiptsService = $receiptsService;
        $this->statusesService = $statusesService;

        $this->contestStartDate = Carbon::createFromDate(2020, 5, 1, 'Europe/Moscow')->setTime(0, 0, 0);
        $this->contestEndDate = Carbon::createFromDate(2020, 6, 22, 'Europe/Moscow')->setTime(0, 0, 0);
    }

    /**
     * Запуск команды.
     *
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $this->checkQrDuplicates();
        $this->checkFnsDuplicates();
        $this->moderate();
    }

    /**
     * Получаем чеки для модерации.
     *
     * @return Collection
     */
    protected function getItems(): Collection
    {
        $status = $this->statusesService->getDefaultStatus();

        if (! $status) {
            return collect([]);
        }

        return $this->receiptsService->getModel()->where(
            [
                ['status_id', '=', $status->id],
            ]
        )->get();
    }

    /**
     * Модерируем чеки.
     *
     * @throws BindingResolutionException
     */
    protected function moderate(): void
    {
        $items = $this->getItems();

        $preliminarilyApprovedStatus = $this->statusesService
            ->getModel()
            ->where('alias', '=', 'preliminarily_approved')
            ->first();

        $rejectedStatus = $this->statusesService
            ->getModel()
            ->where('alias', '=', 'rejected')
            ->first();

        if (! $preliminarilyApprovedStatus || ! $rejectedStatus) {
            return;
        }

        foreach ($items as $item) {
            if (! $item->created_at->greaterThanOrEqualTo($this->contestStartDate)) {
                $this->moderateItem($item, $rejectedStatus, 'Загрузка до начала конкурса');

                continue;
            }

            if ($item->created_at->greaterThanOrEqualTo($this->contestEndDate)) {
                $this->moderateItem($item, $rejectedStatus, 'Загрузка после окончания конкурса');

                continue;
            }

            $receipt = $item->fnsReceipt;

            if (! $receipt) {
                continue;
            }

            $receiptDate = Carbon::parse($receipt['receipt']['document']['receipt']['dateTime']);

            if (! $receiptDate->greaterThanOrEqualTo($this->contestStartDate)) {
                $this->moderateItem($item, $rejectedStatus, 'Покупка до начала конкурса');

                continue;
            }

            if ($receiptDate->greaterThanOrEqualTo($this->contestEndDate)) {
                $this->moderateItem($item, $rejectedStatus, 'Покупка после окончания конкурса');

                continue;
            }

            $hasProduct = false;

            foreach ($receipt['receipt']['document']['receipt']['items'] ?? [] as $productItem) {
                if ($this->checkReceiptProduct($productItem)) {
                    $hasProduct = true;
                }
            }

            if ($hasProduct) {
                $this->moderateItem($item, $preliminarilyApprovedStatus);

                continue;
            }
        }
    }

    /**
     * Проверка чеков на дубли qr кодов.
     *
     * @throws BindingResolutionException
     */
    protected function checkQrDuplicates(): void
    {
        $items = $this->getItems();

        $rejectedStatus = $this->statusesService
            ->getModel()
            ->where('alias', 'rejected')
            ->first();

        $bar = $this->output->createProgressBar(count($items));

        $codes = [];

        foreach ($items as $item) {
            $receiptCodes = $item->getJSONData('receipt_data', 'codes', []);

            if (empty($receiptCodes) || $item['status_id'] === $rejectedStatus['id']) {
                continue;
            }

            foreach ($receiptCodes as $receiptCode) {
                if (($receiptCode['type'] ?? '') == 'QR_CODE') {
                    $codeValue = trim($receiptCode['value'] ?? '');

                    if (! $codeValue) {
                        continue;
                    }

                    if (! $item->hasJSONData('receipt_data', 'duplicate') && isset($codes[$codeValue])) {
                        $item->setJSONData('receipt_data', 'duplicate', true);

                        $this->moderateItem($item, $rejectedStatus, 'Дубликат');
                    } else {
                        $codes[$codeValue] = $item->id;
                    }
                }
            }

            $bar->advance();
        }

        $bar->finish();
    }

    /**
     * Проверка чеков на дубли fns.
     *
     * @throws BindingResolutionException
     */
    protected function checkFnsDuplicates(): void
    {
        $items = $this->getItems();

        $rejectedStatus = $this->statusesService
            ->getModel()
            ->where('alias', 'rejected')
            ->first();

        $bar = $this->output->createProgressBar(count($items));

        $fnsData = [];

        foreach ($items as $item) {
            $receipt = $item->fnsReceipt;

            if (! $receipt) {
                continue;
            }

            if (($receipt['receipt']['document']['receipt']['rawData'] ?? '')) {
                $rawData = trim($receipt['receipt']['document']['receipt']['rawData']);

                if (! $rawData) {
                    continue;
                }

                if (! $item->hasJSONData('receipt_data', 'duplicate') && isset($fnsData[$rawData])) {
                    $item->setJSONData('receipt_data', 'duplicate', true);

                    $this->moderateItem($item, $rejectedStatus, 'Дубликат');
                } else {
                    $fnsData[$rawData] = $item->id;
                }
            }

            $bar->advance();
        }

        $bar->finish();
    }

    /**
     * Переводим чек на нужный статус.
     *
     * @param  ReceiptModelContract  $item
     * @param  StatusModelContract  $status
     * @param  string  $reason
     *
     * @return ReceiptModelContract
     *
     * @throws BindingResolutionException
     */
    protected function moderateItem(ReceiptModelContract $item, StatusModelContract $status, string $reason = ''): ReceiptModelContract
    {
        $item->status_id = $status['id'];

        if ($reason) {
            $item->setJSONData('receipt_data', 'statusReason', $reason);
        }

        $item->save();

        event(
            app()->make(
                'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModerateItemEventContract',
                compact('item')
            )
        );

        return $item;
    }

    /**
     * Проверяем, что продукт соответствует условиям.
     *
     * @param  array  $product
     *
     * @return bool
     */
    protected function checkReceiptProduct(array $product): bool
    {
        return (mb_strpos(mb_strtolower($product['name']), 'cast') !== false && mb_strpos(mb_strtolower($product['name']), 'краск') !== false) ||
            (mb_strpos(mb_strtolower($product['name']), 'каст') !== false && mb_strpos(mb_strtolower($product['name']), 'краск') !== false) ||
            (mb_strpos(mb_strtolower($product['name']), 'casting') !== false && mb_strpos(mb_strtolower($product['name']), 'д/в') !== false) ||
            (mb_strpos(mb_strtolower($product['name']), 'casting') !== false && mb_strpos(mb_strtolower($product['name']), 'крас') !== false);
    }
}
