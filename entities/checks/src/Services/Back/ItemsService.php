<?php

namespace InetStudio\ChecksContest\Checks\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  CheckModelContract  $model
     */
    public function __construct(CheckModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return CheckModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $id): CheckModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';

        $receiptData = Arr::pull($data, 'receipt_data', []);

        $itemData = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($itemData, $id);

        $receiptData = array_merge($item['receipt_data'] ?? [], $receiptData);
        $item = $this->saveModel(['receipt_data' => $receiptData], $id);

        if (Arr::has($data, 'prizes')) {
            $prizesData = Arr::get($data, 'prizes', []);

            app()->make('InetStudio\ChecksContest\Prizes\Contracts\Services\Back\ItemsServiceContract')
                ->attachToObject($prizesData, $item);
        }

        if (Arr::has($data, 'products')) {
            $productsData = Arr::get($data, 'products', []);

            app()->make('InetStudio\ChecksContest\Products\Contracts\Services\Back\ItemsServiceContract')
                ->attachToObject($productsData, $item);
        }

        event(
            app()->make(
                'InetStudio\ChecksContest\Checks\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        Session::flash('success', 'Чек успешно '.$action);

        return $item;
    }
}
