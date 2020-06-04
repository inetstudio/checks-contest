<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Resources\Back\Moderation;

use Illuminate\Http\Resources\Json\ResourceCollection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Moderation\ItemsCollectionContract;

class ItemsCollection extends ResourceCollection implements ItemsCollectionContract
{
    public function __construct($resource)
    {
        $itemResource = app()->make(
            'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Moderation\ItemResourceContract',
            [
                'resource' => null,
            ]
        );

        $this->collects = get_class($itemResource);

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'items' => $this->collection,
            'success' => (count($this->collection) > 0)
        ];
    }
}
