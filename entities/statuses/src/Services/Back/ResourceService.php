<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Statuses\Services\Back;

use InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ReceiptsContest\Statuses\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\DTO\Back\Resource\Save\ItemDataContract;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\ItemsServiceContract as ClassifiersEntriesServiceContract;

class ResourceService extends BaseItemsService implements ResourceServiceContract
{
    protected ClassifiersEntriesServiceContract $classifiersEntriesService;

    public function __construct(StatusModelContract $model, ClassifiersEntriesServiceContract $classifiersEntriesService)
    {
        parent::__construct($model);

        $this->classifiersEntriesService = $classifiersEntriesService;
    }

    public function create(): StatusModelContract
    {
        return new $this->model;
    }

    public function show(int $id): StatusModelContract
    {
        $item = $this->model::find($id);

        return $item;
    }

    public function save(ItemDataContract $data): StatusModelContract
    {
        $item = $this->model::find($data->id) ?? new $this->model;

        $item->name = $data->name;
        $item->alias = $data->alias;
        $item->description = $data->description;
        $item->color_class = $data->color_class;

        $item->save();

        $this->classifiersEntriesService->attachToObject($data->classifiers, $item);

        event(
            resolve(
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
