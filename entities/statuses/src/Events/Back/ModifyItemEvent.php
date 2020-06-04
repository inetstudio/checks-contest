<?php

namespace InetStudio\ReceiptsContest\Statuses\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Events\Back\ModifyItemEventContract;

class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    public StatusModelContract $item;

    public function __construct(StatusModelContract $item)
    {
        $this->item = $item;
    }
}
