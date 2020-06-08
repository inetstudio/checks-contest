<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Resources\Back\Resource\Show;

use stdClass;
use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'receipt_data' => (empty($this['receipt_data'])) ? new stdClass() : $this['receipt_data'],
            'fns_receipt' => $this['fnsReceipt'],
            'additional_info' => (empty($this['additional_info'])) ? new stdClass() : $this['additional_info'],
            'status' => resolve('InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract', ['resource' => $this['status']]),
            'products' => resolve('InetStudio\ReceiptsContest\Products\Contracts\Http\Resources\Back\Resource\Show\ItemsCollectionContract', ['resource' => $this['products']]),
            'prizes' => resolve('InetStudio\ReceiptsContest\Prizes\Contracts\Http\Resources\Back\Resource\Show\ItemsCollectionContract', ['resource' => $this['prizes']]),
        ];
    }
}
