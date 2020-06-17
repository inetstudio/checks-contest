<?php

namespace InetStudio\ReceiptsContest\Receipts\Console\Commands;

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\DTO\Back\Moderation\Moderate\ItemData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ModerateServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\ModerateCommandContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract as ReceiptsServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract as StatusesServiceContract;

class ModerateCommand extends Command implements ModerateCommandContract
{
    protected $signature = 'inetstudio:receipts-contest:receipts:moderate';

    protected $description = 'Moderate receipts';

    protected ReceiptsServiceContract $receiptsService;

    protected StatusesServiceContract $statusesService;

    protected ModerateServiceContract $moderateService;

    protected CarbonInterface $contestStartDate;

    protected CarbonInterface $contestEndDate;

    public function __construct(ReceiptsServiceContract $receiptsService, StatusesServiceContract $statusesService, ModerateServiceContract $moderateService)
    {
        parent::__construct();

        $this->receiptsService = $receiptsService;
        $this->statusesService = $statusesService;
        $this->moderateService = $moderateService;

        $this->contestStartDate = Carbon::createFromDate(2020, 5, 1, 'Europe/Moscow')->setTime(0, 0, 0);
        $this->contestEndDate = Carbon::createFromDate(2020, 6, 22, 'Europe/Moscow')->setTime(0, 0, 0);
    }

    public function handle()
    {
        $this->checkQrDuplicates();
        $this->checkFnsDuplicates();
        $this->moderate();
    }

    protected function getItems(): Collection
    {
        $statuses = $this->statusesService->getItemsByType('default');

        if ($statuses->count() === 0) {
            return collect([]);
        }

        return $this->receiptsService->getItemsByStatuses($statuses);
    }

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
                $this->moderateItem(
                    $item,
                    $rejectedStatus,
                    [
                        'statusReason' => 'Загрузка до начала конкурса',
                    ]
                );

                continue;
            }

            if ($item->created_at->greaterThanOrEqualTo($this->contestEndDate)) {
                $this->moderateItem(
                    $item,
                    $rejectedStatus,
                    [
                        'statusReason' => 'Загрузка после окончания конкурса',
                    ]
                );

                continue;
            }

            $receipt = $item->fnsReceipt;

            if (! $receipt) {
                continue;
            }

            $receiptDate = Carbon::parse($receipt['receipt']['document']['receipt']['dateTime']);

            if (! $receiptDate->greaterThanOrEqualTo($this->contestStartDate)) {
                $this->moderateItem(
                    $item,
                    $rejectedStatus,
                    [
                        'statusReason' => 'Покупка до начала конкурса',
                    ]
                );

                continue;
            }

            if ($receiptDate->greaterThanOrEqualTo($this->contestEndDate)) {
                $this->moderateItem(
                    $item,
                    $rejectedStatus,
                    [
                        'statusReason' => 'Покупка после окончания конкурса',
                    ]
                );

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
                if (($receiptCode['type'] ?? '') === 'QR_CODE') {
                    $codeValue = trim($receiptCode['value'] ?? '');

                    if (! $codeValue) {
                        continue;
                    }

                    if (! $item->hasJSONData('receipt_data', 'duplicate') && isset($codes[$codeValue])) {
                        $this->moderateItem(
                            $item,
                            $rejectedStatus,
                            [
                                'statusReason' => 'Дубликат',
                                'duplicate' => true
                            ]
                        );
                    } else {
                        $codes[$codeValue] = $item->id;
                    }
                }
            }

            $bar->advance();
        }

        $bar->finish();
    }

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
                    $this->moderateItem(
                        $item,
                        $rejectedStatus,
                        [
                            'statusReason' => 'Дубликат',
                            'duplicate' => true
                        ]
                    );
                } else {
                    $fnsData[$rawData] = $item->id;
                }
            }

            $bar->advance();
        }

        $bar->finish();
    }

    protected function moderateItem(ReceiptModelContract $item, StatusModelContract $status, array $receiptData = []): void
    {
        $data = new ItemData(
            [
                'id' => $item['id'],
                'status_id' => $status['id'],
                'receipt_data' => $receiptData,
            ]
        );

        $this->moderateService->moderate($data);
    }

    protected function checkReceiptProduct(array $product): bool
    {
        return (mb_strpos(mb_strtolower($product['name']), 'l.p.') !== false);
    }
}
