<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Statuses\Services\Back;

use InetStudio\ReceiptsContest\Statuses\Contracts\DTO\ItemDataContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ReceiptsContest\Statuses\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract;

class ItemsService extends BaseItemsService implements ItemsServiceContract
{
    public function save(ItemDataContract $data): StatusModelContract
    {
        $item = $this->model::updateOrCreate(
            [
                'id' => $data->id,
            ],
            $data->except('id', 'classifiers')->toArray()
        );

        $classifiersData = $data->classifiers;
        app()->make('InetStudio\Classifiers\Entries\Contracts\Services\Back\ItemsServiceContract')
            ->attachToObject($classifiersData, $item);

        event(
            app()->make(
                'InetStudio\ReceiptsContest\Statuses\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        return $item;
    }

    public function destroy($id): int
    {
        return $this->model::destroy($id);
    }
}
