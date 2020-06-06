<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Resources\Back\Moderation;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Moderation\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'status' => view(
                'admin.module.receipts-contest.receipts::back.partials.datatables.status',
                [
                    'item' => $this,
                ]
            )->render(),
            'moderation' => view(
                'admin.module.receipts-contest.receipts::back.partials.datatables.moderation',
                [
                    'item' => $this
                ]
            )->render(),
            'updated_at' => (string) $this['updated_at'],
        ];
    }
}
