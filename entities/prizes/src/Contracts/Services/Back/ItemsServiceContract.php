<?php

namespace InetStudio\ChecksContest\Prizes\Contracts\Services\Back;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;

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
     * @return PrizeModelContract
     */
    public function save(array $data, int $id): PrizeModelContract;
}
