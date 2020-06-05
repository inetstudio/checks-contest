<?php

namespace InetStudio\ReceiptsContest\Receipts\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\SetWinnerEventContract;

class SetWinnerEvent implements SetWinnerEventContract
{
    use SerializesModels;

    public ReceiptModelContract $item;

    public PrizeModelContract $prize;

    public function __construct(ReceiptModelContract $item, PrizeModelContract $prize)
    {
        $this->item = $item;
        $this->prize = $prize;
    }
}
