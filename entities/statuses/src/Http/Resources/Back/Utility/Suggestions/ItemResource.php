<?php

namespace InetStudio\ReceiptsContest\Statuses\Http\Resources\Back\Utility\Suggestions;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Utility\Suggestions\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
        ];
    }
}
