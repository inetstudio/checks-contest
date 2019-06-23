<?php

namespace InetStudio\ChecksContest\Checks\Contracts\Services\Back;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;

/**
 * Interface ModerateServiceContract.
 */
interface ModerateServiceContract extends BaseServiceContract
{
    /**
     * Модерация чека.
     *
     * @param  int  $id
     * @param  string  $statusAlias
     *
     * @return CheckModelContract|null
     */
    public function moderate(int $id, string $statusAlias): ?CheckModelContract;
}
