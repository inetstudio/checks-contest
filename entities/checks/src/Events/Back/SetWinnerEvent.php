<?php

namespace InetStudio\ChecksContest\Checks\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Events\Back\SetWinnerEventContract;

/**
 * Class SetWinnerEvent.
 */
class SetWinnerEvent implements SetWinnerEventContract
{
    use SerializesModels;

    /**
     * @var CheckModelContract
     */
    public $check;

    /**
     * @var
     */
    public $prize;

    /**
     * SetWinnerEvent constructor.
     *
     * @param  CheckModelContract  $check
     * @param  PrizeModelContract  $prize
     */
    public function __construct(CheckModelContract $check, PrizeModelContract $prize)
    {
        $this->check = $check;
        $this->prize = $prize;
    }
}
