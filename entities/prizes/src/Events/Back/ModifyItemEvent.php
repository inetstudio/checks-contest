<?php

namespace InetStudio\ReceiptsContest\Prizes\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Events\Back\ModifyItemEventContract;

class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    public PrizeModelContract $item;

    public function __construct(PrizeModelContract $item)
    {
        $this->item = $item;
    }
}
