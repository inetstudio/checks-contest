<?php

namespace InetStudio\ChecksContest\Statuses\Contracts\Transformers\Back\Utility;

use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract;

/**
 * Interface SuggestionTransformerContract.
 */
interface SuggestionTransformerContract
{
    /**
     * Подготовка данных для отображения в выпадающих списках.
     *
     * @param  StatusModelContract  $item
     *
     * @return array
     */
    public function transform(StatusModelContract $item): array;

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection;
}
