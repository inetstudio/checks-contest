<?php

namespace InetStudio\ChecksContest\Statuses\Transformers\Back\Resource;

use Throwable;
use League\Fractal\TransformerAbstract;
use InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ChecksContest\Statuses\Contracts\Transformers\Back\Resource\IndexTransformerContract;

/**
 * Class IndexTransformer.
 */
class IndexTransformer extends TransformerAbstract implements IndexTransformerContract
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
        return [
            'id' => (int) $item['id'],
            'name' => $item['name'],
            'alias' => $item['alias'],
            'created_at' => (string) $item['created_at'],
            'updated_at' => (string) $item['updated_at'],
            'actions' => view('admin.module.checks-contest.statuses::back.partials.datatables.actions', compact('item'))
                ->render(),
        ];
    }
}
