<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Moderation;

use InetStudio\ReceiptsContest\Receipts\DTO\Back\Moderation\Moderate\ItemData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ModerateServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Moderation\ModerateResponseContract;

class ModerateResponse implements ModerateResponseContract
{
    protected ModerateServiceContract $moderateService;

    public function __construct(ModerateServiceContract $moderateService)
    {
        $this->moderateService = $moderateService;
    }

    public function toResponse($request)
    {
        $data = ItemData::fromRequest($request);

        $resource = collect([$this->moderateService->moderate($data)]);

        return resolve(
            'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Moderation\ItemsCollectionContract',
            compact('resource')
        );
    }
}
