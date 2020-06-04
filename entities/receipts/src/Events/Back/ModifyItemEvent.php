<?php

namespace InetStudio\ReceiptsContest\Receipts\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var ReceiptModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param  ReceiptModelContract  $item
     */
    public function __construct(ReceiptModelContract $item)
    {
        $this->item = $item;
    }
}
