<?php

namespace InetStudio\ReceiptsContest\Receipts\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModerateItemEventContract;

/**
 * Class ModerateItemEvent.
 */
class ModerateItemEvent implements ModerateItemEventContract
{
    use SerializesModels;

    /**
     * @var ReceiptModelContract
     */
    public $item;

    /**
     * ModerateItemEvent constructor.
     *
     * @param  ReceiptModelContract  $item
     */
    public function __construct(ReceiptModelContract $item)
    {
        $this->item = $item;
    }
}
