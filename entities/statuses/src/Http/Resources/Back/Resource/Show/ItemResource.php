<?php

namespace InetStudio\ReceiptsContest\Statuses\Http\Resources\Back\Resource\Show;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'alias' => $this['alias'],
            'description' => $this['description'],
            'color_class' => $this['color_class'],
        ];
    }
}
