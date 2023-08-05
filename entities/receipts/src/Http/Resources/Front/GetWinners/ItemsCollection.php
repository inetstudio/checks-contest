<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Resources\Front\GetWinners;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemsCollection extends ResourceCollection
{
    public $collects = ItemResource::class;

    public function toArray($request): array
    {
        return [
            'status' => 200,
            'message' => 'The resources successfully fetched.',
            'data' => $this->collection,
        ];
    }
}
