<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Prizes\DTO\Back\Items\Attach;

use Spatie\DataTransferObject\DataTransferObject;
use InetStudio\ReceiptsContest\Prizes\Contracts\DTO\Back\Items\Attach\ItemDataContract;

class ItemData extends DataTransferObject implements ItemDataContract
{
    public int $id;

    public PivotData $pivot;
}
