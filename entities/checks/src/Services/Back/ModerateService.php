<?php

namespace InetStudio\ChecksContest\Checks\Services\Back;

use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Services\Back\ModerateServiceContract;

/**
 * Class ModerateService.
 */
class ModerateService extends BaseService implements ModerateServiceContract
{
    /**
     * ModerateService constructor.
     *
     * @param  CheckModelContract  $model
     */
    public function __construct(CheckModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Модерация чека.
     *
     * @param  int  $id
     * @param  string  $statusAlias
     *
     * @return CheckModelContract|null
     *
     * @throws BindingResolutionException
     */
    public function moderate(int $id, string $statusAlias): ?CheckModelContract
    {
        $statusesService = app()->make('InetStudio\ChecksContest\Statuses\Contracts\Services\Back\ItemsServiceContract');

        $item = $this->getItemById($id);

        $status = $statusesService->getModel()
            ->where('alias', '=', $statusAlias)
            ->first();

        if (! $item->id || ! $status) {
            return null;
        }

        $item = $this->saveModel(
            [
                'status_id' => $status->id,
            ],
            $item->id
        )->fresh();

        event(
            app()->make(
                'InetStudio\ChecksContest\Checks\Contracts\Events\Back\ModerateItemEventContract',
                compact('item')
            )
        );

        return $item;
    }
}
