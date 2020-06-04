<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Resources\Front\Search;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Front\Search\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request)
    {
        /** @var Carbon $createdAt */
        $createdAt = $this['created_at'];

        return [
            'id' => $this['id'],
            'date' => Carbon::formatDateToRus($createdAt->format('d.m.Y')),
            'time' => $createdAt->format('H:i'),
            'status' => $this['status']['name'],
        ];
    }
}
