<?php

namespace InetStudio\ReceiptsContest\Receipts\Services\Back;

use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ModerateServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Back\Moderation\Moderate\ItemDataContract;

class ModerateService extends BaseItemsService implements ModerateServiceContract
{
    public function moderate(ItemDataContract $data): ReceiptModelContract
    {
        $item = $this->model::find($data->id);

        $item->status_id = $data->status_id;
        $item->setJSONData('receipt_data', 'statusReason', $data->receipt_data['statusReason'] ?? '');
        $item->setJSONData('receipt_data', 'duplicate', $data->receipt_data['duplicate'] ?? false);

        $item->save();

        event(
            resolve(
                'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModerateItemEventContract',
                compact('item')
            )
        );

        return $item;
    }
}
