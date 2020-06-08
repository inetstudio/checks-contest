<?php

namespace InetStudio\ReceiptsContest\Receipts\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Back\Items\AddBarcodes\ItemDataContract as AddBarcodesDataContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Back\Items\AttachFnsReceipt\ItemDataContract as AttachFnsReceiptDataContract;

class ItemsService extends BaseItemsService implements ItemsServiceContract
{
    public function attachFnsReceipt(AttachFnsReceiptDataContract $data): ReceiptModelContract
    {
        $item = $this->model::find($data->id);

        $item->receipt_id = $data->receipt_id;

        $item->save();

        event(
            resolve(
                'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        return $item;
    }

    public function addBarcodes(AddBarcodesDataContract $data): ReceiptModelContract
    {
        $item = $this->model::find($data->id);

        $item->setJSONData('receipt_data', 'codes', $data->receipt_data['codes'] ?? []);

        $item->save();

        event(
            resolve(
                'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        return $item;
    }

    public function getItemsByStatuses(Collection $statuses): Collection
    {
        $statusesIds = $statuses->pluck('id')->toArray();

        return $this->model::with('media', 'status', 'prizes', 'fnsReceipt', 'products')
            ->whereIn('status_id', $statusesIds)
            ->get();
    }

    public function getItemsWithoutFnsReceiptByStatuses(Collection $statuses): Collection
    {
        $statusesIds = $statuses->pluck('id')->toArray();

        return $this->model::with('media', 'status', 'prizes', 'fnsReceipt', 'products')
            ->whereIn('status_id', $statusesIds)
            ->doesntHave('fnsReceipt')
            ->get();
    }
}
