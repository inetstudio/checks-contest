<?php

namespace InetStudio\ChecksContest\Products\Transformers\Back\Resource;

use Throwable;
use League\Fractal\TransformerAbstract;
use InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract;
use InetStudio\ChecksContest\Products\Contracts\Transformers\Back\Resource\IndexTransformerContract;

/**
 * Class IndexTransformer.
 */
class IndexTransformer extends TransformerAbstract implements IndexTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param  ProductModelContract  $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(ProductModelContract $item): array
    {
        return [
            'id' => (int) $item['id'],
            'name' => $item['name'],
            'alias' => $item['alias'],
            'created_at' => (string) $item['created_at'],
            'updated_at' => (string) $item['updated_at'],
            'actions' => view('admin.module.checks-contest.products::back.partials.datatables.actions', compact('item'))
                ->render(),
        ];
    }
}
