<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Resources\Back\Resource\Show;

use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'receipt_data' => $this['receipt_data'],
            'fns_receipt' => $this['fnsReceipt'],
            'additional_info' => $this['additional_info'],
            'status' => $this['status'],
            'products' => $this['products'],
            'prizes' => $this['prizes'],
        ];
    }
}
