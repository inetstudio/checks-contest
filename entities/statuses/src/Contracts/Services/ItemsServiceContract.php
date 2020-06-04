<?php

namespace InetStudio\ReceiptsContest\Statuses\Contracts\Services;

use Illuminate\Database\Eloquent\Collection;
use InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract;

interface ItemsServiceContract
{
    public function getModel(): StatusModelContract;

    public function create(): StatusModelContract;

    public function getItemById($id = 0, bool $returnNew = true);

    public function getItemsByType(string $type): Collection;
}
