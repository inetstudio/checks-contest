<?php

namespace InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Resource;

use Illuminate\Support\Facades\Session;
use InetStudio\ReceiptsContest\Statuses\DTO\ItemData;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Resource\StoreResponseContract;

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

        Session::flash('success', 'Статус «'.$item['name'].'» успешно создан');

        return response()->redirectToRoute('back.receipts-contest.statuses.edit', $item['id']);
    }
}
