<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Front;

use Illuminate\Contracts\Support\Responsable;
use Packages\ReceiptsContest\Receipts\Http\Resources\Front\GetWinners\ItemsCollection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract;

class GetWinnersResponse implements Responsable
{
    protected ItemsServiceContract $itemsService;

    public function __construct(ItemsServiceContract $itemsService)
    {
        $this->itemsService = $itemsService;
    }

    public function toResponse($request)
    {
        $page = $request->get('page', 0);
        $limit = $request->get('limit', 6);

        $resource = $this->itemsService->getWinners($page, $limit);

        return (new ItemsCollection($resource))->response();
    }
}
