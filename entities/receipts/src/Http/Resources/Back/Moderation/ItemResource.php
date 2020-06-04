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
                    'item' => $this['status'],
                ]
            )->render(),
            'moderation' => view(
                'admin.module.receipts-contest.receipts::back.partials.datatables.moderation',
                [
                    'item' => $this
                ]
            )->render(),
            'prizes' => view(
                'admin.module.receipts-contest.receipts::back.partials.datatables.prizes',
                [
                    'prizes' => $this['prizes'],
                ]
            )->render(),
            'updated_at' => (string) $this['updated_at'],
        ];
    }
}
