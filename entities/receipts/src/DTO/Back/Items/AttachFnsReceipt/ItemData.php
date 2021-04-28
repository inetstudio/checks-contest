<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Receipts\DTO\Back\Items\AttachFnsReceipt;

use Spatie\DataTransferObject\DataTransferObject;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Back\Items\AttachFnsReceipt\ItemDataContract;

class ItemData extends DataTransferObject implements ItemDataContract
{
    public int $id;

    public ?string $fns_receipt_id;
}
