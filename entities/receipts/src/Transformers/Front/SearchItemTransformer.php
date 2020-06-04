<?php

namespace InetStudio\ReceiptsContest\Receipts\Transformers\Front;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Transformers\Front\SearchItemTransformerContract;

/**
 * Class SearchItemTransformer.
 */
class SearchItemTransformer extends TransformerAbstract implements SearchItemTransformerContract
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
        /** @var Carbon $createdAt */
        $createdAt = $item['created_at'];

        return [
            'id' => $item['id'],
            'date' => Carbon::formatDateToRus($item['created_at']->format('d.m.Y')),
            'time' => $createdAt->format('H:i'),
            'status' => $item['status']['name'],
        ];
    }

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection
    {
        return new FractalCollection($items, $this);
    }
}
