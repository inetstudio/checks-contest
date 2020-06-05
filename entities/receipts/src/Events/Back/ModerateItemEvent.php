<?php

namespace InetStudio\ReceiptsContest\Receipts\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModerateItemEventContract;

class ModerateItemEvent implements ModerateItemEventContract
{
    use SerializesModels;

    public ReceiptModelContract $item;

    public function __construct(ReceiptModelContract $item)
    {
        $this->item = $item;
    }
}
