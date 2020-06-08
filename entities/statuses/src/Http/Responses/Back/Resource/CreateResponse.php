<?php

namespace InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Resource\CreateResponseContract;

class CreateResponse implements CreateResponseContract
{
    protected ResourceServiceContract $resourceService;

    public function __construct(ResourceServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $item = $this->resourceService->create();

        return response()->view('admin.module.receipts-contest.statuses::back.pages.form', compact('item'));
    }
}
