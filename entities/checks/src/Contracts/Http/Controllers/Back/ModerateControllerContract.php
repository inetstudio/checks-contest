<?php

namespace InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\ChecksContest\Checks\Contracts\Services\Back\ItemsServiceContract;
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
     * @param  ItemsServiceContract  $receiptsService
     * @param  Request  $request
     * @param  int  $id
     * @param  string  $statusAlias
     *
     * @return ModerateResponseContract
     */
    public function moderate(
        ModerateServiceContract $moderateService,
        ItemsServiceContract $receiptsService,
        Request $request,
        int $id,
        string $statusAlias
    ): ModerateResponseContract;
}
