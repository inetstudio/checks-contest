<?php

namespace InetStudio\ChecksContest\Checks\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Services\Back\ModerateServiceContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Back\ModerateControllerContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Moderate\ModerateResponseContract;

/**
 * Class ModerateController.
 */
class ModerateController extends Controller implements ModerateControllerContract
{
    /**
     * Модерация чека.
     *
     * @param  ModerateServiceContract  $moderateService
     * @param  int  $id
     * @param  string  $statusAlias
     *
     * @return ModerateResponseContract
     *
     * @throws BindingResolutionException
     */
    public function moderate(
        ModerateServiceContract $moderateService,
        int $id,
        string $statusAlias
    ): ModerateResponseContract {
        $item = $moderateService->moderate($id, $statusAlias);

        return $this->app->make(
            ModerateResponseContract::class,
            [
                'result' => ($item && $item->status->alias == $statusAlias),
                'item' => $item,
            ]
        );
    }
}
