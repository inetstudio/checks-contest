<?php

namespace InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back;

use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\DTO\Back\Items\Attach\ItemsCollectionContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

interface ItemsServiceContract extends BaseItemsServiceContract
{
    public function attach(ReceiptModelContract $item, ItemsCollectionContract $prizes): void;
}
