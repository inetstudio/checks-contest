<?php

namespace InetStudio\ReceiptsContest\Receipts\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\SetWinnerEventContract;

/**
 * Class SetWinnerEvent.
 */
class SetWinnerEvent implements SetWinnerEventContract
{
    use SerializesModels;

    /**
     * @var ReceiptModelContract
     */
    public $check;

    /**
     * @var
     */
    public $prize;

    /**
     * SetWinnerEvent constructor.
     *
     * @param  ReceiptModelContract  $check
     * @param  PrizeModelContract  $prize
     */
    public function __construct(ReceiptModelContract $check, PrizeModelContract $prize)
    {
        $this->check = $check;
        $this->prize = $prize;
    }
}
