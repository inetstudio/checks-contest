<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\ShowResponseContract;

class ShowResponse implements ShowResponseContract
{
    protected ResourceServiceContract $resourceService;

    public function __construct(ResourceServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $id = $request->route('receipt');

        $resource = $this->resourceService->show($id);

        return resolve(
            'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract',
            compact('resource')
        );
    }
}
