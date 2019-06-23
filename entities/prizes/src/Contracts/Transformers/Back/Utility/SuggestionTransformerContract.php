<?php

namespace InetStudio\ChecksContest\Prizes\Contracts\Transformers\Back\Utility;

use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;

/**
 * Interface SuggestionTransformerContract.
 */
interface SuggestionTransformerContract
{
    /**
     * Подготовка данных для отображения в выпадающих списках.
     *
     * @param  PrizeModelContract  $item
     *
     * @return array
     */
    public function transform(PrizeModelContract $item): array;

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection;
}
