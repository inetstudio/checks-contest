<?php

namespace InetStudio\ReceiptsContest\Receipts\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class AttachProductsCommand.
 */
class AttachProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inetstudio:receipts-contest:receipts:attach-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attach products to receipts';

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

        $checks = $checksService->getModel()->has('fnsReceipt')->doesntHave('products')->get();

        foreach ($checks as $check) {
            $fnsReceipt = $check->fnsReceipt;
            $fnsReceiptData = $fnsReceipt->receipt['document']['receipt'];

            $products = [];

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

            $check->products()->createMany($products);
            $check->setJSONData('receipt_data', 'receipt', Arr::except($fnsReceiptData, ['items']));
            $check->save();
        }
    }
}
