<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Resources\Back\Resource\Update;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Resource\Update\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request)
    {
        $userData = $this['additional_info'];

        return [
            'id' => $this['id'],
            'prizes' => view(
                'admin.module.receipts-contest.receipts::back.partials.datatables.prizes',
                [
                    'item' => $this
                ]
            )->render(),
            'name' => trim(($userData['personal']['surname'] ?? '').' '.($userData['personal']['name'] ?? '').' '.($userData['personal']['middleName'] ?? '')) ?? ($userData['personal']['name'] ?? ''),
            'email' => $userData['personal']['email'] ?? '',
            'phone' => $userData['personal']['phone'] ?? '',
            'updated_at' => (string) $this['updated_at'],
        ];
    }
}
