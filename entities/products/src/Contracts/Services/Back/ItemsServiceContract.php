<?php

namespace InetStudio\ChecksContest\Products\Contracts\Services\Back;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends BaseServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return ProductModelContract
     */
    public function save(array $data, int $id): ProductModelContract;
}
