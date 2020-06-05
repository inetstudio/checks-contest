<?php

namespace InetStudio\ReceiptsContest\Receipts\Events\Front;

use Illuminate\Queue\SerializesModels;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Events\Front\SendItemEventContract;

class SendItemEvent implements SendItemEventContract
{
    use SerializesModels;

    public ReceiptModelContract $item;

    public function __construct(ReceiptModelContract $item)
    {
        $this->item = $item;
    }
}
