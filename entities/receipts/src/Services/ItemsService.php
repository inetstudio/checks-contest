<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Receipts\Services;

use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\ItemsServiceContract;

class ItemsService implements ItemsServiceContract
{
    protected ReceiptModelContract $model;

    public function __construct(ReceiptModelContract $model)
    {
        $this->model = $model;
    }

    public function getModel(): ReceiptModelContract
    {
        return $this->model;
    }

    public function create(): ReceiptModelContract
    {
        return new $this->model;
    }

    public function getItemById($id = 0, bool $returnNew = true): ?ReceiptModelContract
    {
        return $this->model::with('media', 'status', 'prizes', 'fnsReceipt', 'products')->find($id) ?? (($returnNew) ? $this->create() : null);
    }

    public function getItemsByStatuses(Collection $statuses): Collection
    {
        $statusesIds = $statuses->pluck('id')->toArray();

        return $this->model::with('media', 'status', 'prizes', 'fnsReceipt', 'products')
            ->whereIn('status_id', $statusesIds)
            ->get();
    }

    public function getItemsWithoutFnsReceiptByStatuses(Collection $statuses): Collection
    {
        $statusesIds = $statuses->pluck('id')->toArray();

        return $this->model::with('media', 'status', 'prizes', 'fnsReceipt', 'products')
            ->whereIn('status_id', $statusesIds)
            ->doesntHave('fnsReceipt')
            ->get();
    }
}
