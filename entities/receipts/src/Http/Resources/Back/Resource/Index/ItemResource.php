<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Resources\Back\Resource\Index;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Resource\Index\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request)
    {
        $userData = $this['additional_info'];

        return [
            'DT_RowId' => 'receipt_row_'.$this['id'],
            'id' => $this['id'],
            'receipt_data' => $this['receipt_data'],
            'fnsReceipt' => $this['fnsReceipt']['data'] ?? '',
            'additional_info' => $userData,
            'status' => view(
                'admin.module.receipts-contest.receipts::back.partials.datatables.status',
                [
                    'item' => $this
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
                    'item' => $this
                ]
            )->render(),
            'receipt_image' => view(
                'admin.module.receipts-contest.receipts::back.partials.datatables.receipt_image',
                [
                    'item' => $this
                ]
            )->render(),
            'name' => trim(($userData['personal']['surname'] ?? '').' '.($userData['personal']['name'] ?? '').' '.($userData['personal']['middleName'] ?? '')) ?? ($userData['personal']['name'] ?? ''),
            'email' => $userData['personal']['email'] ?? '',
            'phone' => $userData['personal']['phone'] ?? '',
            'created_at' => (string) $this['created_at'],
            'updated_at' => (string) $this['updated_at'],
            'actions' => view(
                'admin.module.receipts-contest.receipts::back.partials.datatables.actions',
                [
                    'item' => $this
                ]
            )->render(),
        ];
    }
}
