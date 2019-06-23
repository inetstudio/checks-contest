<?php

namespace InetStudio\ChecksContest\Checks\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var CheckModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param  CheckModelContract  $item
     */
    public function __construct(CheckModelContract $item)
    {
        $this->item = $item;
    }
}
