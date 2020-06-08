<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Receipts\DTO\Back\Items\AttachFnsReceipt;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Back\Items\AttachFnsReceipt\ItemDataContract;

class ItemData extends FlexibleDataTransferObject implements ItemDataContract
{
    public int $id;

    public int $receipt_id = 0;
}
