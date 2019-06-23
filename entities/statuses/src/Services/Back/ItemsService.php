<?php

namespace InetStudio\ChecksContest\Statuses\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ChecksContest\Statuses\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  StatusModelContract  $model
     */
    public function __construct(StatusModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return StatusModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $id): StatusModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';

        $itemData = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($itemData, $id);

        $classifiersData = Arr::get($data, 'classifiers', []);
        app()->make('InetStudio\Classifiers\Entries\Contracts\Services\Back\ItemsServiceContract')
            ->attachToObject($classifiersData, $item);

        event(
            app()->make(
                'InetStudio\ChecksContest\Statuses\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        Session::flash('success', 'Статус «'.$item->name.'» успешно '.$action);

        return $item;
    }

    /**
     * Возвращаем статус по умолчанию.
     *
     * @return StatusModelContract|null
     */
    public function getDefaultStatus(): ?StatusModelContract
    {
        $status = $this->getModel()->whereHas('classifiers', function ($classifiersQuery) {
            $classifiersQuery->select(['classifiers_entries.id', 'classifiers_entries.alias'])
                ->where('classifiers_entries.alias', 'checks_contest_status_default');
        })->first();

        if (! $status) {
            $status = $this->getModel()->first();
        }

        return $status;
    }
}
