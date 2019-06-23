<?php

namespace InetStudio\ChecksContest\Statuses\Contracts\Services\Back;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract;

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
     * @return StatusModelContract
     */
    public function save(array $data, int $id): StatusModelContract;
}
