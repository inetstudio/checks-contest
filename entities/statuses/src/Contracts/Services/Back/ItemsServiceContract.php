<?php

namespace InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back;

use InetStudio\ReceiptsContest\Statuses\Contracts\DTO\ItemDataContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

interface ItemsServiceContract extends BaseItemsServiceContract
{
    public function save(ItemDataContract $data): StatusModelContract;

    public function destroy($id): int;
}
