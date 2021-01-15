<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Products\DTO\Back\Items\Attach;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\ReceiptsContest\Products\Contracts\DTO\Back\Items\Attach\ItemDataContract;

class ItemData extends FlexibleDataTransferObject implements ItemDataContract
{
    /**
     * @var int|string
     */
    public $id = 0;

    public ?string $fns_receipt_id = null;

    public int $receipt_id = 0;

    public string $name;

    /**
     * @var float|int
     */
    public $quantity = 0;

    public int $price = 0;

    public array $product_data = [];
}
