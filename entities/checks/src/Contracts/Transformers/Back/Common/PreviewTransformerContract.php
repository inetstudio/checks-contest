<?php

namespace InetStudio\ChecksContest\Checks\Contracts\Transformers\Back\Common;

use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;

/**
 * Interface PreviewTransformerContract.
 */
interface PreviewTransformerContract
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
