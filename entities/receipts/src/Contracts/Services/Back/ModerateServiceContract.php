<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back;

use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Back\Moderation\Moderate\ItemDataContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

interface ModerateServiceContract extends BaseItemsServiceContract
{
    public function moderate(ItemDataContract $data): ReceiptModelContract;
}
