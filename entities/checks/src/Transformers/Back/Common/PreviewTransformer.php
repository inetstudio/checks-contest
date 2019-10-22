<?php

namespace InetStudio\ChecksContest\Checks\Transformers\Back\Common;

use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Transformers\Back\Common\PreviewTransformerContract;

/**
 * Class PreviewTransformer.
 */
class PreviewTransformer extends BaseTransformer implements PreviewTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  CheckModelContract  $item
     *
     * @return array
     */
    public function transform(CheckModelContract $item): array
    {
        $receiptImage = $item->getFirstMedia('images');

        return [
            'id' => $receiptImage->id ?? 0,
            'thumb' => ($receiptImage) ? url($receiptImage->getUrl('admin_index_thumb')) : '',
            'src' => ($receiptImage) ? url($receiptImage->getUrl()) : '',
        ];
    }
}
