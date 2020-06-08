<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Receipts\Services;

use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\ItemsServiceContract;

class ItemsService implements ItemsServiceContract
{
    protected ReceiptModelContract $model;

    public function __construct(ReceiptModelContract $model)
    {
        $this->model = $model;
    }

    public function getModel(): ReceiptModelContract
    {
        return $this->model;
    }
}
