<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\ShowResponseContract;

class ShowResponse implements ShowResponseContract
{
    protected ItemsServiceContract $resourceService;

    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $id = $request->route('receipt');

        $resource = $this->resourceService->getItemById($id);

        return app()->make(
            'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract',
            compact('resource')
        );
    }
}
