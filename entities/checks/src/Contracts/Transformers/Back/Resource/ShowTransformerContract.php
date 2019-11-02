<?php

namespace InetStudio\ChecksContest\Checks\Contracts\Transformers\Back\Resource;

use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;

/**
 * Interface ShowTransformerContract.
 */
interface ShowTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  CheckModelContract  $item
     *
     * @return array
     */
    public function transform(CheckModelContract $item): array;
}