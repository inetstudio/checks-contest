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
        $item = $this->model::updateOrCreate(
            [
                'id' => $data->id,
            ],
            $data->except('id')->toArray()
        );

        event(
            app()->make(
                'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModerateItemEventContract',
                compact('item')
            )
        );

        return $item;
    }
}
