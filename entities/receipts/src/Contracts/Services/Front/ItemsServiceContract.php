<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front;

use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Front\SendItemDataContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

interface ItemsServiceContract extends BaseItemsServiceContract
{
    public function send(SendItemDataContract $data): ?ReceiptModelContract;

    public function getContestStages(): array;

    public function search(string $field, string $search, string $type): Collection;
}
