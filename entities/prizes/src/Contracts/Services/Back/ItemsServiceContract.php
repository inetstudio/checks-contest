<?php

namespace InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back;

use InetStudio\ReceiptsContest\Prizes\Contracts\DTO\ItemDataContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends BaseItemsServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param  ItemDataContract  $data
     *
     * @return PrizeModelContract
     */
    public function save(ItemDataContract $data): PrizeModelContract;

    /**
     * Удаляем модель.
     *
     * @param  mixed  $id
     *
     * @return int
     */
    public function destroy($id): int;

    /**
     * Присваиваем призы объекту.
     *
     * @param  array  $prizes
     * @param $item
     */
    public function attachToObject(array $prizes, $item): void;
}
