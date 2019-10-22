<?php

namespace InetStudio\ChecksContest\Statuses\Contracts\Transformers\Back\Resource;

use InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract;

/**
 * Interface ShowTransformerContract.
 */
interface ShowTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  StatusModelContract  $item
     *
     * @return array
     */
    public function transform(StatusModelContract $item): array;
}
