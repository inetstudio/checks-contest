<?php

namespace InetStudio\ChecksContest\Products\Contracts\Transformers\Back\Resource;

use InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract;

/**
 * Interface IndexTransformerContract.
 */
interface IndexTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param  ProductModelContract  $item
     *
     * @return array
     */
    public function transform(ProductModelContract $item): array;
}
