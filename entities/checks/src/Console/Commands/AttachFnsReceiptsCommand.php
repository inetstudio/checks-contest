<?php

namespace InetStudio\ChecksContest\Checks\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Console\Commands\AttachFnsReceiptsCommandContract;

/**
 * Class AttachFnsReceiptsCommand.
 */
class AttachFnsReceiptsCommand extends Command implements AttachFnsReceiptsCommandContract
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inetstudio:checks-contest:checks:fns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attach FNS receipts to contest checks';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Запуск команды.
     *
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $checksService = app()->make('InetStudio\ChecksContest\Checks\Contracts\Services\Back\ItemsServiceContract');
        $statusesService = app()->make('InetStudio\ChecksContest\Statuses\Contracts\Services\Back\ItemsServiceContract');
        $receiptsService = app()->make('InetStudio\Fns\Receipts\Contracts\Services\Back\ItemsServiceContract');

        $status = $statusesService->getDefaultStatus();

        $checks = $checksService->getModel()->where([
            ['status_id', '=', $status->id],
        ])->doesntHave('fnsReceipts')->get();

        $bar = $this->output->createProgressBar(count($checks));

        foreach ($checks as $check) {
            $codes = $check->getJSONData('receipt_data', 'codes', []);

            $receiptsIds = [];
            $products = [];

            foreach ($codes as $code) {
                if (! (($code[0] ?? '') == 'QR_CODE')) {
                    continue;
                }

                if (! ($code[1] ?? '')) {
                    continue;
                }

                $fnsReceipt = $receiptsService->getReceiptByQrCode($code[1]);

                if ($fnsReceipt) {
                    $receiptsIds[] = $fnsReceipt['id'];

                    $fnsReceiptData = $fnsReceipt->receipt['document']['receipt'];

                    foreach ($fnsReceiptData['items'] ?? [] as $item) {
                        $products[] = [
                            'fns_receipt_id' => $fnsReceipt->id,
                            'name' => $item['name'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                        ];
                    }
                }
            }

            if (! empty($receiptsIds)) {
                $check->fnsReceipts()->sync($receiptsIds);
            }

            $check->products()->createMany($products);
            $check->receipt_data = Arr::except($fnsReceiptData, ['items']);
            $check->save();

            $bar->advance();
        }

        $bar->finish();
    }
}
