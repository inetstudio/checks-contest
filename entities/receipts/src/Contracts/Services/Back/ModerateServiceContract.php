<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back;

use InetStudio\ReceiptsContest\Receipts\DTO\Back\Moderation\ModerateItemData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

interface ModerateServiceContract extends BaseItemsServiceContract
{
    public function moderate(ModerateItemData $data): ReceiptModelContract;
}
