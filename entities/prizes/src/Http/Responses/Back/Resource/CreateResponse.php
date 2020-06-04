<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\CreateResponseContract;

/**
 * Class CreateResponse.
 */
class CreateResponse implements CreateResponseContract
{
    protected ItemsServiceContract $resourceService;

    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $item = $this->resourceService->create();

        return response()->view('admin.module.receipts-contest.prizes::back.pages.form', compact('item'));
    }
}
