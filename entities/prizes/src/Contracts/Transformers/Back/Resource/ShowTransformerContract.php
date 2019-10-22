<?php

namespace InetStudio\ChecksContest\Prizes\Contracts\Transformers\Back\Resource;

use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;

/**
 * Interface ShowTransformerContract.
 */
interface ShowTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param  PrizeModelContract  $item
     *
     * @return array
     */
    public function transform(PrizeModelContract $item): array;
}
