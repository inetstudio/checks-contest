<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back;

use InetStudio\ReceiptsContest\Receipts\DTO\Back\Resource\Update\ItemData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

interface ResourceServiceContract extends BaseItemsServiceContract
{
    public function show(int $id): ReceiptModelContract;

    public function update(ItemData $data): ReceiptModelContract;

    public function destroy($id): int;
}
