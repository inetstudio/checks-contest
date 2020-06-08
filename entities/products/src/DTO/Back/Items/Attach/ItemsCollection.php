<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Products\DTO\Back\Items\Attach;

use Spatie\DataTransferObject\DataTransferObjectCollection;
use InetStudio\ReceiptsContest\Products\Contracts\DTO\Back\Items\Attach\ItemsCollectionContract;

class ItemsCollection extends DataTransferObjectCollection implements ItemsCollectionContract
{
    public function current(): ItemData
    {
        return parent::current();
    }
}
