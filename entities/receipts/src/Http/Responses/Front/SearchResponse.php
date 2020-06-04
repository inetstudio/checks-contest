<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Front;

use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SearchResponseContract;

class SearchResponse implements SearchResponseContract
{
    protected ItemsServiceContract $itemsService;

    public function __construct(ItemsServiceContract $itemsService)
    {
        $this->itemsService = $itemsService;
    }

    public function toResponse($request)
    {
        $field = $request->route('field', 'email');
        $type = $request->route('type', '');
        $query = $request->input('query', '');

        $resource = $this->itemsService->search($field, $query, $type);

        return app()->make(
            'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Front\Search\ItemsCollectionContract',
            compact('resource')
        );
    }
}
