<?php

namespace InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back;

use InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\DTO\Back\Resource\Save\ItemDataContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\ItemsServiceContract as BaseItemsServiceContract;

interface ResourceServiceContract extends BaseItemsServiceContract
{
    public function create(): StatusModelContract;

    public function show(int $id): StatusModelContract;

    public function save(ItemDataContract $data): StatusModelContract;

    public function destroy($id): int;
}
