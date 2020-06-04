<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Receipts\DTO\ItemData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\StoreResponseContract;

class StoreResponse implements StoreResponseContract
{
    protected ItemsServiceContract $resourceService;

    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $data = ItemData::fromRequest($request);

        $item = $this->resourceService->save($data);

        return response()->json($item);
    }
}
