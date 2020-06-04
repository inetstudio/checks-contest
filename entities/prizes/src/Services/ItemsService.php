<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Prizes\Services;

use InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Services\ItemsServiceContract;

class ItemsService implements ItemsServiceContract
{
    protected PrizeModelContract $model;

    public function __construct(PrizeModelContract $model)
    {
        $this->model = $model;
    }

    public function getModel(): PrizeModelContract
    {
        return $this->model;
    }

    public function create(): PrizeModelContract
    {
        return new $this->model;
    }

    public function getItemById($id = 0, bool $returnNew = true)
    {
        return $this->model::find($id) ?? (($returnNew) ? $this->create() : null);
    }
}
