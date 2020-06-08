<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

interface ItemsServiceContract extends BaseItemsServiceContract
{
    public function getItemsByStatuses(Collection $statuses): Collection;

    public function getItemsWithoutFnsReceiptByStatuses(Collection $statuses): Collection;
}
