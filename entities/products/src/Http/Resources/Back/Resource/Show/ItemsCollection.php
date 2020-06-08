<?php

namespace InetStudio\ReceiptsContest\Products\Http\Resources\Back\Resource\Show;

use Illuminate\Http\Resources\Json\ResourceCollection;
use InetStudio\ReceiptsContest\Products\Contracts\Http\Resources\Back\Resource\Show\ItemsCollectionContract;

class ItemsCollection extends ResourceCollection implements ItemsCollectionContract
{
    public function __construct($resource)
    {
        $this->collects = 'InetStudio\ReceiptsContest\Products\Http\Resources\Back\Resource\Show\ItemResource';

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return $this->collection;
    }
}
