<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Receipts\DTO\Back\Items\AddBarcodes;

use Spatie\DataTransferObject\DataTransferObject;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Back\Items\AddBarcodes\ItemDataContract;

class ItemData extends DataTransferObject implements ItemDataContract
{
    public int $id;

    public array $receipt_data;
}
