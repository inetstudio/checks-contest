<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\EditResponseContract;

class EditResponse implements EditResponseContract
{
    protected ItemsServiceContract $resourceService;

    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $id = $request->route('prize', 0);

        $item = $this->resourceService->getItemById($id);

        return response()->view('admin.module.receipts-contest.prizes::back.pages.form', compact('item'));
    }
}
