<?php

namespace InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Resource\ShowResponseContract;

class ShowResponse implements ShowResponseContract
{
    protected ItemsServiceContract $resourceService;

    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $id = $request->route('status');

        $item = $this->resourceService->getItemById($id);

        return response()->json($item->toArray());
    }
}
