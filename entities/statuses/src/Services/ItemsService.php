<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Statuses\Services;

use Illuminate\Database\Eloquent\Collection;
use InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\ItemsServiceContract;

class ItemsService implements ItemsServiceContract
{
    protected StatusModelContract $model;

    public function __construct(StatusModelContract $model)
    {
        $this->model = $model;
    }

    public function getModel(): StatusModelContract
    {
        return $this->model;
    }

    public function create(): StatusModelContract
    {
        return new $this->model;
    }

    public function getItemById($id = 0, bool $returnNew = true)
    {
        return $this->model::find($id) ?? (($returnNew) ? $this->create() : null);
    }

    public function getItemsByType(string $type): Collection
    {
        return $this->model::whereHas(
            'classifiers',
            function ($classifiersQuery) use ($type) {
                $classifiersQuery->select(['classifiers_entries.id', 'classifiers_entries.alias'])
                    ->where('classifiers_entries.alias', 'receipts_contest_status_'.$type);
            }
        )->get();
    }
}
