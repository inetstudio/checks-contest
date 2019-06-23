<?php

namespace InetStudio\ChecksContest\Checks\Contracts\Transformers\Front;

use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;

/**
 * Interface SearchItemTransformerContract.
 */
interface SearchItemTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  CheckModelContract  $item
     *
     * @return array
     */
    public function transform(CheckModelContract $item): array;

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection;
}
