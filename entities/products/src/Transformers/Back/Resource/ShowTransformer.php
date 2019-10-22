<?php

namespace InetStudio\ChecksContest\Products\Transformers\Back\Resource;

use Throwable;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract;
use InetStudio\ChecksContest\Products\Contracts\Transformers\Back\Resource\ShowTransformerContract;

/**
 * Class ShowTransformer.
 */
class ShowTransformer extends BaseTransformer implements ShowTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param  ProductModelContract  $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(ProductModelContract $item): array
    {
        $data = $item->toArray();
        $data['highlight'] = false;

        return $data;
    }
}
