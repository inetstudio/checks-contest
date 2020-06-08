<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource;

use Illuminate\Support\Facades\Session;
use InetStudio\ReceiptsContest\Prizes\DTO\Back\Resource\Save\ItemData;
use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\UpdateResponseContract;

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

        $item = $this->resourceService->save($data);

        Session::flash('success', 'Приз «'.$item['name'].'» успешно обновлен');

        return response()->redirectToRoute('back.receipts-contest.prizes.edit', $item['id']);
    }
}
