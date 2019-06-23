<?php

namespace InetStudio\ChecksContest\Checks\Contracts\Services\Back;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;

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
     * @return CheckModelContract
     */
    public function save(array $data, int $id): CheckModelContract;
}
