<?php

namespace InetStudio\ChecksContest\Products\Services\Back;

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
        if (! $products) {
            return;
        }

        if ($products instanceof Request) {
            $products = $products->get('products');

            if (! $products) {
                return;
            }
        }

        if (is_string($products)) {
            $products = json_decode($products, true);
        }

        if (! empty($products)) {
            $productsIds = collect($products)->pluck('id')->toArray();
            $item->products()->whereNotIn('id', $productsIds)->delete();

            foreach ($products as $product) {
                $this->save($product, is_numeric($product['id']) ? (int) $product['id'] : 0);
            }
        } else {
            $item->products()->delete();
        }
    }
}
