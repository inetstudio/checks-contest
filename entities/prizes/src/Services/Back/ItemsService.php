<?php

namespace InetStudio\ChecksContest\Prizes\Services\Back;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ChecksContest\Prizes\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  PrizeModelContract  $model
     */
    public function __construct(PrizeModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return PrizeModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $id): PrizeModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';

        $itemData = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($itemData, $id);

        event(
            app()->make(
                'InetStudio\ChecksContest\Prizes\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        Session::flash('success', 'Приз «'.$item['name'].'» успешно '.$action);

        return $item;
    }

    /**
     * Присваиваем призы объекту.
     *
     * @param $prizes
     * @param $item
     *
     * @throws BindingResolutionException
     */
    public function attachToObject($prizes, $item): void
    {
        if ($prizes instanceof Request) {
            $prizes = $prizes->get('prizes', []);
        } else {
            $prizes = (array) $prizes;
        }

        $oldPrizes = $item->prizes;

        if (! empty($prizes)) {
            $prizes = collect($prizes)->mapWithKeys(function ($item, $key) {
                return [
                    $key => [
                        'date_start' => Carbon::createFromFormat('d.m.Y', $item['date_start'])->setTime(0, 0, 0)->format('Y-m-d H:i:s'),
                        'date_end' => ($item['date_end'] != $item['date_start'] && $item['date_end'] != null)
                            ? Carbon::createFromFormat('d.m.Y', $item['date_end'])->setTime(0, 0, 0)->format('Y-m-d H:i:s')
                            : null,
                        'confirmed' => (int ) ($item['confirmed'] ?? 0),
                    ],
                ];
            })->toArray();

            $item->prizes()->sync($prizes);
        } else {
            $item->prizes()->detach();
        }

        $newPrizes = $item->fresh()->prizes;

        $this->fireWinnerEvent($item, $oldPrizes, $newPrizes);
    }

    /**
     * Событие при подтверждении приза.
     *
     * @param $check
     * @param $oldPrizes
     * @param $newPrizes
     *
     * @throws BindingResolutionException
     */
    protected function fireWinnerEvent($check, $oldPrizes, $newPrizes): void
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
                        'InetStudio\ChecksContest\Checks\Contracts\Events\Back\SetWinnerEventContract',
                        compact('check', 'prize')
                    )
                );
            }
        }
    }
}
