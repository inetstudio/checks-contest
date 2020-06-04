<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Prizes\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\ReceiptsContest\Prizes\Contracts\DTO\ItemDataContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ReceiptsContest\Prizes\Services\ItemsService as BaseItemsService;
use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ItemsServiceContract;

class ItemsService extends BaseItemsService implements ItemsServiceContract
{
    public function save(ItemDataContract $data): PrizeModelContract
    {
        $item = $this->model::updateOrCreate(
            [
                'id' => $data->id,
            ],
            $data->except('id')->toArray()
        );

        event(
            app()->make(
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

    public function attachToObject($prizes, $item): void
    {
        if ($prizes === null) {
            return;
        }

        $oldPrizes = $item->prizes;

        if (! empty($prizes)) {
            $prizes = collect($prizes)->mapWithKeys(function ($item) {
                return [
                    $item->id => $item->pivot->except('created_at', 'updated_at')->toArray(),
                ];
            })->toArray();

            $item->prizes()->sync($prizes);
        } else {
            $item->prizes()->detach();
        }

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
            if ($prize->pivot->confirmed == 1 && (isset($oldConfirmed[$prize->id]) && $oldConfirmed[$prize->id] == 0 || ! isset($oldConfirmed[$prize->id]))) {
                event(
                    app()->make(
                        'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\SetWinnerEventContract',
                        compact('receipt', 'prize')
                    )
                );
            }
        }
    }
}
