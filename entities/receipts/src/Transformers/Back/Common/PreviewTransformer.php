<?php

namespace InetStudio\ReceiptsContest\Receipts\Transformers\Back\Common;

use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Transformers\Back\Common\PreviewTransformerContract;

/**
 * Class PreviewTransformer.
 */
class PreviewTransformer extends BaseTransformer implements PreviewTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  ReceiptModelContract  $item
     *
     * @return array
     */
    public function transform(ReceiptModelContract $item): array
    {
        $receiptImage = $item->getFirstMedia('images');

        return [
            'id' => $receiptImage->id ?? 0,
            'thumb' => ($receiptImage) ? url($receiptImage->getUrl('admin_index_thumb')) : '',
            'src' => ($receiptImage) ? url($receiptImage->getUrl()) : '',
        ];
    }
}
