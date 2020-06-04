<?php

namespace InetStudio\ReceiptsContest\Products\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ReceiptsContest\Products\Contracts\Models\ProductModelContract;
use InetStudio\ReceiptsContest\Products\Contracts\Events\Back\ModifyItemEventContract;

class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    public ProductModelContract $item;

    public function __construct(ProductModelContract $item)
    {
        $this->item = $item;
    }
}
