<?php

namespace InetStudio\ChecksContest\Products\Services\Back;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract;
use InetStudio\ChecksContest\Products\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  ProductModelContract  $model
     */
    public function __construct(ProductModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return ProductModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $id): ProductModelContract
    {
        $action = ($id) ? 'отредактирован' : 'создан';

        $itemData = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($itemData, $id);

        event(
            app()->make(
                'InetStudio\ChecksContest\Products\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        Session::flash('success', 'Продукт «'.$item['name'].'» успешно '.$action);

        return $item;
    }

    /**
     * Присваиваем продукты объекту.
     *
     * @param $products
     * @param $item
     *
     * @throws BindingResolutionException
     */
    public function attachToObject($products, $item): void
    {
        if ($products instanceof Request) {
            $products = $products->get('products', []);
        } else {
            $products = (array) $products;
        }

        $oldProducts = $item->products;

        if (! empty($products)) {
            $products = collect($products)->mapWithKeys(function ($item, $key) {
                return [
                    $key => [
                        'date_start' => Carbon::createFromFormat('d.m.Y', $item['date_start'])->setTime(0, 0, 0)->format('Y-m-d H:i:s'),
                        'date_end' => ($item['date_end'] != $item['date_start'] && $item['date_end'] != null)
                            ? Carbon::createFromFormat('d.m.Y', $item['date_end'])->setTime(0, 0, 0)->format('Y-m-d H:i:s')
                            : null,
                        'confirmed' => (int) ($item['confirmed'] ?? 0),
                    ],
                ];
            })->toArray();

            $item->products()->sync($products);
        } else {
            $item->products()->detach();
        }

        $newProducts = $item->fresh()->products;

        $this->fireWinnerEvent($item, $oldProducts, $newProducts);
    }

    /**
     * Событие при подтверждении продукта.
     *
     * @param $check
     * @param $oldProducts
     * @param $newProducts
     *
     * @throws BindingResolutionException
     */
    protected function fireWinnerEvent($check, $oldProducts, $newProducts): void
    {
        $oldConfirmed = $oldProducts->mapWithKeys(function ($item) {
            return [
                $item->id => $item->pivot->confirmed,
            ];
        });

        foreach ($newProducts as $product) {
            if ($product->pivot->confirmed == 1 && (isset($oldConfirmed[$product->id]) && $oldConfirmed[$product->id] == 0 || ! isset($oldConfirmed[$product->id]))) {
                event(
                    app()->make(
                        'InetStudio\ChecksContest\Checks\Contracts\Events\Back\SetWinnerEventContract',
                        compact('check', 'product')
                    )
                );
            }
        }
    }
}
