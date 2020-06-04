<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back;

use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\ItemDataContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

interface ItemsServiceContract extends BaseItemsServiceContract
{
    public function save(ItemDataContract $data): ReceiptModelContract;
}
