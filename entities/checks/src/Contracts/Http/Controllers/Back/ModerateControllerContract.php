<?php

namespace InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Back;

use InetStudio\ChecksContest\Checks\Contracts\Services\Back\ModerateServiceContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Moderate\ModerateResponseContract;

/**
 * Interface ModerateControllerContract.
 */
interface ModerateControllerContract
{
    /**
     * Модерация чека.
     *
     * @param  ModerateServiceContract  $moderateService
     * @param  int  $id
     * @param  string  $statusAlias
     *
     * @return ModerateResponseContract
     */
    public function moderate(
        ModerateServiceContract $moderateService,
        int $id,
        string $statusAlias
    ): ModerateResponseContract;
}
