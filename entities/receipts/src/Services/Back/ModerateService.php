<?php

namespace InetStudio\ReceiptsContest\Receipts\Services\Back;

use InetStudio\ReceiptsContest\Receipts\DTO\Back\Moderation\ModerateItemData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ModerateServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract as StatusesServiceContract;

class ModerateService extends ItemsService implements ModerateServiceContract
{
    protected StatusesServiceContract $statusesService;

    public function __construct(StatusesServiceContract $statusesService, ReceiptModelContract $model)
    {
        parent::__construct($model);

        $this->statusesService = $statusesService;
    }

    public function moderate(ModerateItemData $data): ReceiptModelContract
    {
        $item = $this->model::where('id', $data->id)->first();

        $item->status_id = $data->status_id;
        $item->setJSONData('receipt_data', 'statusReason', $data->receipt_data['statusReason'] ?? '');
        $item->save();

        event(
            app()->make(
                'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModerateItemEventContract',
                compact('item')
            )
        );

        return $item;
    }
}
