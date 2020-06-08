<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Prizes\Services\Back;

use InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ReceiptsContest\Prizes\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ResourceServiceContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\DTO\Back\Resource\Save\ItemDataContract;

class ResourceService extends BaseItemsService implements ResourceServiceContract
{
    public function create(): PrizeModelContract
    {
        return new $this->model;
    }

    public function show(int $id): PrizeModelContract
    {
        $item = $this->model::find($id);

        return $item;
    }

    public function save(ItemDataContract $data): PrizeModelContract
    {
        $item = $this->model::updateOrCreate(
            [
                'id' => $data->id,
            ],
            $data->except('id')->toArray()
        );

        event(
            resolve(
                'InetStudio\ReceiptsContest\Prizes\Contracts\Events\Back\ModifyItemEventContract',
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
