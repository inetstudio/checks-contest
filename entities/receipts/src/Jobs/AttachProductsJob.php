<?php

namespace InetStudio\ReceiptsContest\Receipts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Products\DTO\Back\Items\Attach\ItemData as ProductData;
use InetStudio\ReceiptsContest\Products\Contracts\Services\Back\ItemsServiceContract as ProductsServiceContract;

final class AttachProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ReceiptModelContract $receipt;

    protected ProductsServiceContract $productsService;

    public function __construct(ReceiptModelContract $receipt)
    {
        $this->receipt = $receipt->fresh(['status', 'fnsReceipt']);
    }

    public function handle(
        ProductsServiceContract $productsService
    ) {
        $this->productsService = $productsService;

        if ($this->receipt->status->alias === 'rejected') {
            return;
        }

        $this->attachProducts();
    }

    protected function attachProducts()
    {
        $fnsReceipt = $this->receipt->fnsReceipt;

        if (! $fnsReceipt) {
            return;
        }

        $products = [];

        $fnsReceiptData = $fnsReceipt->data;

        foreach ($fnsReceiptData['content']['items'] ?? [] as $item) {
            $products[] = new ProductData(
                [
                    'receipt_id' => $this->receipt->id,
                    'fns_receipt_id' => $fnsReceipt->id,
                    'name' => $item['name'],
                    'quantity' => (float) $item['quantity'],
                    'price' => (int) $item['price'],
                    'product_data' => $item,
                ]
            );
        }

        $this->productsService->attach($this->receipt, $products);
    }
}
