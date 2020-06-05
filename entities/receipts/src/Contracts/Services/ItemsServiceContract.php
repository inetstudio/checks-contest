<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Services;

use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;

interface ItemsServiceContract
{
    public function getModel(): ReceiptModelContract;

    public function create(): ReceiptModelContract;

    public function getItemById($id = 0, bool $returnNew = true);

    public function getItemsByStatuses(Collection $statuses): Collection;

    public function getItemsWithoutFnsReceiptByStatuses(Collection $statuses): Collection;
}
