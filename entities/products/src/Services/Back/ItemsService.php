<?php

namespace InetStudio\ReceiptsContest\Products\Services\Back;

use InetStudio\ReceiptsContest\Products\Contracts\Models\ProductModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Products\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ReceiptsContest\Products\Contracts\DTO\Back\Items\Attach\ItemDataContract;
use InetStudio\ReceiptsContest\Products\Contracts\DTO\Back\Items\Attach\ItemsCollectionContract;

class ItemsService implements ItemsServiceContract
{
    protected ProductModelContract $model;

    public function __construct(ProductModelContract $model)
    {
        $this->model = $model;
    }

    public function save(ItemDataContract $data): ProductModelContract
    {
        $id = is_string($data->id) ? 0 : $data->id;

        $item = $this->model::find($id) ?? new $this->model;

        $item->fns_receipt_id = $data->fns_receipt_id;
        $item->receipt_id = $data->receipt_id;
        $item->name = $data->name;
        $item->quantity = $data->quantity;
        $item->price = $data->price;
        $item->product_data = $data->product_data;

        $item->save();

        event(
            resolve(
                'InetStudio\ReceiptsContest\Products\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        return $item;
    }

    public function attach(ReceiptModelContract $item, ItemsCollectionContract $products): void
    {
        if ($products->count() === 0) {
            $item->products()->delete();

            return;
        }

        $productsIds = collect($products->toArray())->filter(function ($productItem) {
            return ! is_string($productItem['id']);
        })->pluck('id')->toArray();
        $item->products()->whereNotIn('id', $productsIds)->delete();

        foreach ($products->items() as $product) {
            $this->save($product);
        }
    }
}
