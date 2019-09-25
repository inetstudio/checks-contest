<?php

namespace InetStudio\ChecksContest\Products\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract;
use InetStudio\ChecksContest\Products\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var ProductModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param  ProductModelContract  $item
     */
    public function __construct(ProductModelContract $item)
    {
        $this->item = $item;
    }
}
