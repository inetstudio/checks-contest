<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Transformers\Front;

use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;

/**
 * Interface SearchItemTransformerContract.
 */
interface SearchItemTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  ReceiptModelContract  $item
     *
     * @return array
     */
    public function transform(ReceiptModelContract $item): array;

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection;
}
