<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Transformers\Back\Common;

use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;

/**
 * Interface PreviewTransformerContract.
 */
interface PreviewTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  ReceiptModelContract  $item
     *
     * @return array
     */
    public function transform(ReceiptModelContract $item): array;
}
