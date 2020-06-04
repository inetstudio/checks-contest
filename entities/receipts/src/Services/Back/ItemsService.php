<?php

namespace InetStudio\ReceiptsContest\Receipts\Services\Back;

use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\ItemDataContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract;

class ItemsService extends BaseItemsService implements ItemsServiceContract
{
    public function save(ItemDataContract $data): ReceiptModelContract
    {
        $item = $this->model::updateOrCreate(
            [
                'id' => $data->id,
            ],
            $data->except('id', 'status', 'prizes')->toArray()
        );

        app()->make('InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ItemsServiceContract')
            ->attachToObject($data->prizes, $item);

        event(
            app()->make(
                'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        return $item->fresh();
    }

    /*
    public function save(array $data, int $id): ReceiptModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';

        $receiptData = Arr::pull($data, 'receipt_data', []);

        $itemData = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($itemData, $id);

        $receiptData = array_merge($item['receipt_data'] ?? [], $receiptData);
        $item = $this->saveModel(['receipt_data' => $receiptData], $id);

        if (Arr::has($data, 'prizes')) {
            $prizesData = Arr::get($data, 'prizes', []);

            app()->make('InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ItemsServiceContract')
                ->attachToObject($prizesData, $item);
        }

        if (Arr::has($data, 'products')) {
            $productsData = Arr::get($data, 'products', []);

            app()->make('InetStudio\ReceiptsContest\Products\Contracts\Services\Back\ItemsServiceContract')
                ->attachToObject($productsData, $item);
        }

        event(
            app()->make(
                'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        return $item;
    }
    */

    public function destroy($id): int
    {
        return $this->model::destroy($id);
    }
}
