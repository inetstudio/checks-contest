<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Resources\Front\Search;

use Illuminate\Http\Resources\Json\ResourceCollection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Front\Search\ItemsCollectionContract;

class ItemsCollection extends ResourceCollection implements ItemsCollectionContract
{
    public function __construct($resource)
    {
        $itemResource = resolve(
            'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Front\Search\ItemResourceContract',
            [
                'resource' => null,
            ]
        );

        $this->collects = get_class($itemResource);

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return $this->collection;
    }
}
