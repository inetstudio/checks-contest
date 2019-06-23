<?php

namespace InetStudio\ChecksContest\Prizes\Transformers\Back\Resource;

use Throwable;
use League\Fractal\TransformerAbstract;
use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ChecksContest\Prizes\Contracts\Transformers\Back\Resource\IndexTransformerContract;

/**
 * Class IndexTransformer.
 */
class IndexTransformer extends TransformerAbstract implements IndexTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param  PrizeModelContract  $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(PrizeModelContract $item): array
    {
        return [
            'id' => (int) $item['id'],
            'name' => $item['name'],
            'alias' => $item['alias'],
            'created_at' => (string) $item['created_at'],
            'updated_at' => (string) $item['updated_at'],
            'actions' => view('admin.module.checks-contest.prizes::back.partials.datatables.actions', compact('item'))
                ->render(),
        ];
    }
}
