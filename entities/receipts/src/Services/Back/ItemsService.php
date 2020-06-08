<?php

namespace InetStudio\ReceiptsContest\Receipts\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Receipts\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract;

class ItemsService extends BaseItemsService implements ItemsServiceContract
{
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
