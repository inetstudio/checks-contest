<?php

namespace InetStudio\ChecksContest\Products\Contracts\Transformers\Back\Utility;

use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract;

/**
 * Interface SuggestionTransformerContract.
 */
interface SuggestionTransformerContract
{
    /**
     * Подготовка данных для отображения в выпадающих списках.
     *
     * @param  ProductModelContract  $item
     *
     * @return array
     */
    public function transform(ProductModelContract $item): array;

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection;
}
