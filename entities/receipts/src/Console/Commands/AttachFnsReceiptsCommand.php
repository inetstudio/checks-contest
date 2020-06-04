<?php

namespace InetStudio\ReceiptsContest\Receipts\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\AttachFnsReceiptsCommandContract;

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
    protected $signature = 'inetstudio:receipts-contest:receipts:fns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attach FNS receipts to contest receipts';

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
        $checksService = app()->make('InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract');
        $statusesService = app()->make('InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract');
        $receiptsService = app()->make('InetStudio\Fns\Receipts\Contracts\Services\Back\ItemsServiceContract');

        $status = $statusesService->getDefaultStatus();

        $checks = $checksService->getModel()->where([
            ['status_id', '=', $status->id],
        ])->doesntHave('fnsReceipt')->get();

        $bar = $this->output->createProgressBar(count($checks));

        foreach ($checks as $check) {
            $codes = $check->getJSONData('receipt_data', 'codes', []);

            $products = [];

            foreach ($codes as $code) {
                if (! (($code['type'] ?? '') == 'QR_CODE')) {
                    continue;
                }

                if (! ($code['value'] ?? '')) {
                    continue;
                }

                $fnsReceipt = $receiptsService->getReceiptByQrCode($code[1]);

                if ($fnsReceipt) {
                    $fnsReceiptData = $fnsReceipt->receipt['document']['receipt'];

                    foreach ($fnsReceiptData['items'] ?? [] as $item) {
                        $products[] = [
                            'receipt_id' => $check->id,
                            'fns_receipt_id' => $fnsReceipt->id,
                            'name' => $item['name'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'product_data' => $item,
                        ];
                    }

                    break;
                }
            }

            $check->fns_receipt_id = $fnsReceipt->id ?? 0;
            $check->products()->createMany($products);
            $check->save();

            $bar->advance();
        }

        $bar->finish();
    }
}
