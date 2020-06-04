<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource;

use Illuminate\Support\Facades\Session;
use InetStudio\ReceiptsContest\Prizes\DTO\ItemData;
use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\StoreResponseContract;

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

        Session::flash('success', 'Приз «'.$item['name'].'» успешно создан');

        return response()->redirectToRoute('back.receipts-contest.prizes.edit', $item['id']);
    }
}
