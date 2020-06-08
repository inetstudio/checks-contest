<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Receipts\DTO\Back\Resource\Update\ItemData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\UpdateResponseContract;

class UpdateResponse implements UpdateResponseContract
{
    protected ResourceServiceContract $resourceService;

    public function __construct(ResourceServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $data = ItemData::fromRequest($request);

        $resource = $this->resourceService->update($data);

        return resolve(
            'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Resource\Update\ItemResourceContract',
            compact('resource')
        );
    }
}
