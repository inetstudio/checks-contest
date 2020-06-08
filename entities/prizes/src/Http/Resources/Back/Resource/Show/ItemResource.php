<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Resources\Back\Resource\Show;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'alias' => $this['alias'],
            'pivot' => $this->whenPivotLoaded('receipts_contest_receipts_prizes', function () {
                return [
                    'confirmed' => $this['pivot']['confirmed'],
                    'date_start' => $this['pivot']['date_start'],
                    'date_end' => $this['pivot']['date_end'],
                ];
            }),
        ];
    }
}
