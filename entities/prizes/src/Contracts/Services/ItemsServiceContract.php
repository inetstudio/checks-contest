<?php

namespace InetStudio\ReceiptsContest\Prizes\Contracts\Services;

use InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract;

interface ItemsServiceContract
{
    public function getModel(): PrizeModelContract;
}
