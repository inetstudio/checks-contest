<?php

namespace InetStudio\ChecksContest\Checks\Console\Commands;

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
    protected $signature = 'inetstudio:checks-contest:checks:attach-products';

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
        $checksService = app()->make('InetStudio\ChecksContest\Checks\Contracts\Services\Back\ItemsServiceContract');

        $checks = $checksService->getModel()->has('fnsReceipts')->doesntHave('products')->get();

        foreach ($checks as $check) {
            $fnsReceipt = $check->fnsReceipts->first();
            $fnsReceiptData = $fnsReceipt->receipt['document']['receipt'];

            $products = [];

            foreach ($fnsReceiptData['items'] ?? [] as $item) {
                $products[] = [
                    'fns_receipt_id' => $fnsReceipt->id,
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ];
            }

            $check->products()->createMany($products);
            $check->receipt_data = Arr::except($fnsReceiptData, ['items']);
            $check->save();
        }
    }
}
