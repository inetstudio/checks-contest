<?php

namespace InetStudio\ReceiptsContest\Products\Http\Resources\Back\Resource\Show;

use stdClass;
use Illuminate\Http\Resources\Json\JsonResource;
use InetStudio\ReceiptsContest\Products\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract;

class ItemResource extends JsonResource implements ItemResourceContract
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'fns_receipt_id' => $this['fns_receipt_id'],
            'receipt_id' => $this['receipt_id'],
            'name' => $this['name'],
            'quantity' => $this['quantity'],
            'price' => $this['price'],
            'product_data' => (empty($this['product_data'])) ? new stdClass() : $this['product_data'],
            'highlight' => $this->highlightProduct($this['name']),
        ];
    }

    protected function highlightProduct(string $name): bool
    {
        return (mb_strpos(mb_strtolower($name), 'l.p.') !== false);
    }
}
