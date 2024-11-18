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

        $statusName = $this['status']['name'];
        $statusName = ($statusName === 'Предварительно одобрено') ? 'Модерация' : $statusName;

        $statusReason = $this['receipt_data']['statusReason'] ?? '';

        return [
            'id' => $this['id'],
            'date' => Carbon::formatDateToRus($createdAt->format('d.m.Y')),
            'time' => $createdAt->format('H:i'),
            'status' => [
                'name' => $statusName,
                'reason' => $statusReason,
            ],
            'prizes' => $this['prizes']->map(static function ($prize) {
                return [
                    'id' => $prize->id,
                    'alias' => $prize->alias,
                    'name' => $prize->name,
                ];
            }),            
        ];
    }
}
