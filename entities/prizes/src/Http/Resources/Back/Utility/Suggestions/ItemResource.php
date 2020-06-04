<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Resources\Back\Utility\Suggestions;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Resources\Back\Utility\Suggestions\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
