<?php

namespace InetStudio\ChecksContest\Prizes\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ChecksContest\Prizes\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var PrizeModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param  PrizeModelContract  $item
     */
    public function __construct(PrizeModelContract $item)
    {
        $this->item = $item;
    }
}
