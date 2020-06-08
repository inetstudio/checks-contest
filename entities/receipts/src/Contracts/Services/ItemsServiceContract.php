<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Services;

use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;

interface ItemsServiceContract
{
    public function getModel(): ReceiptModelContract;
}
