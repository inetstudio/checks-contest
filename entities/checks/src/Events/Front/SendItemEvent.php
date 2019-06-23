<?php

namespace InetStudio\ChecksContest\Checks\Events\Front;

use Illuminate\Queue\SerializesModels;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Events\Front\SendItemEventContract;

/**
 * Class SendItemEvent.
 */
class SendItemEvent implements SendItemEventContract
{
    use SerializesModels;

    /**
     * @var CheckModelContract
     */
    public $item;

    /**
     * SendItemEvent constructor.
     *
     * @param  CheckModelContract  $item
     */
    public function __construct(CheckModelContract $item)
    {
        $this->item = $item;
    }
}
