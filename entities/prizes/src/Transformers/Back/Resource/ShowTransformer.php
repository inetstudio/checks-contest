<?php

namespace InetStudio\ChecksContest\Prizes\Transformers\Back\Resource;

use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ChecksContest\Prizes\Contracts\Transformers\Back\Resource\ShowTransformerContract;

/**
 * Class ShowTransformer.
 */
class ShowTransformer extends BaseTransformer implements ShowTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param  PrizeModelContract  $item
     *
     * @return array
     */
    public function transform(PrizeModelContract $item): array
    {
        return $item->toArray();
    }
}
