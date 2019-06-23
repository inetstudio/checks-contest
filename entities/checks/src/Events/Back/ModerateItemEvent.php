<?php

namespace InetStudio\ChecksContest\Checks\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Events\Back\ModerateItemEventContract;

/**
 * Class ModerateItemEvent.
 */
class ModerateItemEvent implements ModerateItemEventContract
{
    use SerializesModels;

    /**
     * @var CheckModelContract
     */
    public $item;

    /**
     * ModerateItemEvent constructor.
     *
     * @param  CheckModelContract  $item
     */
    public function __construct(CheckModelContract $item)
    {
        $this->item = $item;
    }
}
