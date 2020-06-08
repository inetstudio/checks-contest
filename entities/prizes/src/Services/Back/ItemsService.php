<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Prizes\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Prizes\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\DTO\Back\Items\Attach\ItemsCollectionContract;

class ItemsService extends BaseItemsService implements ItemsServiceContract
{
    public function attach(ReceiptModelContract $item, ItemsCollectionContract $prizes): void
    {
        if (count($prizes) === 0) {
            $item->prizes()->detach();

            return;
        }

        $oldPrizes = $item['prizes'];

        $prizes = collect($prizes)->mapWithKeys(function ($prize) {
            return [
                $prize->id => $prize->pivot->toArray(),
            ];
        })->toArray();

        $item->prizes()->sync($prizes);

        $newPrizes = $item->fresh()->prizes;

        $this->fireWinnerEvent($item, $oldPrizes, $newPrizes);
    }

    protected function fireWinnerEvent(ReceiptModelContract $receipt, Collection $oldPrizes, Collection $newPrizes): void
    {
        $oldConfirmed = $oldPrizes->mapWithKeys(function ($item) {
            return [
                $item->id => $item->pivot->confirmed,
            ];
        });

        foreach ($newPrizes as $prize) {
            if (! ($prize->pivot->confirmed === 1 && ($oldConfirmed[$prize->id] ?? 0) === 0)) {
                continue;
            }

            event(
                resolve(
                    'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\SetWinnerEventContract',
                    [
                        'item' => $receipt,
                        'prize' => $prize,
                    ]
                )
            );
        }
    }
}
