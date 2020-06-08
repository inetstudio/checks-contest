<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Resources\Back\Resource\Show;

use Illuminate\Http\Resources\Json\ResourceCollection;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Resources\Back\Resource\Show\ItemsCollectionContract;

class ItemsCollection extends ResourceCollection implements ItemsCollectionContract
{
    public function __construct($resource)
    {
        $itemResource = resolve(
            'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract',
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
