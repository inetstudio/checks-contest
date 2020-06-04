<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Receipts\DTO;

use Spatie\DataTransferObject\DataTransferObjectCollection;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\ItemsCollectionContract;

class ItemsCollection extends DataTransferObjectCollection implements ItemsCollectionContract
{
    public function current(): ItemData
    {
        return parent::current();
    }
}
