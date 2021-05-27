<?php

namespace InetStudio\ReceiptsContest\Products\Contracts\Services\Back;

use InetStudio\ReceiptsContest\Products\Contracts\Models\ProductModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Products\Contracts\DTO\Back\Items\Attach\ItemDataContract;

interface ItemsServiceContract
{
    public function save(ItemDataContract $data): ProductModelContract;

    public function attach(ReceiptModelContract $item, array $products): void;
}
