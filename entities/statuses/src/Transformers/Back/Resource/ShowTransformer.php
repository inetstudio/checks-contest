<?php

namespace InetStudio\ChecksContest\Statuses\Transformers\Back\Resource;

use Throwable;
use League\Fractal\TransformerAbstract;
use InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ChecksContest\Statuses\Contracts\Transformers\Back\Resource\ShowTransformerContract;

/**
 * Class ShowTransformer.
 */
class ShowTransformer extends TransformerAbstract implements ShowTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  StatusModelContract  $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(StatusModelContract $item): array
    {
        return $item->toArray();
    }
}
