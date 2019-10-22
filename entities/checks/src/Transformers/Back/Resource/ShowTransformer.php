<?php

namespace InetStudio\ChecksContest\Checks\Transformers\Back\Resource;

use Throwable;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Transformers\Back\Resource\ShowTransformerContract;

/**
 * Class ShowTransformer.
 */
class ShowTransformer extends BaseTransformer implements ShowTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'preview', 'fnsReceipt', 'status', 'products', 'prizes',
    ];

    /**
     * Трансформация данных.
     *
     * @param  CheckModelContract  $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(CheckModelContract $item): array
    {
        return $item->toArray();
    }

    /**
     * Включаем превью в трансформацию.
     *
     * @param  CheckModelContract  $item
     *
     * @return Item
     *
     * @throws BindingResolutionException
     */
    public function includePreview(CheckModelContract $item): Item
    {
        $transformer = $this->getTransformer('InetStudio\ChecksContest\Checks\Contracts\Transformers\Back\Common\PreviewTransformerContract');

        return $this->item($item, $transformer);
    }

    /**
     * Включаем чек ФНС в трансформацию.
     *
     * @param  CheckModelContract  $item
     *
     * @return Item
     *
     * @throws BindingResolutionException
     */
    public function includeFnsReceipt(CheckModelContract $item): Item
    {
        $transformer = $this->getTransformer('InetStudio\Fns\Receipts\Contracts\Transformers\Back\Resource\ShowTransformerContract');

        return $this->item($item['fnsReceipt'], $transformer);
    }

    /**
     * Включаем статус в трансформацию.
     *
     * @param  CheckModelContract  $item
     *
     * @return Item
     *
     * @throws BindingResolutionException
     */
    public function includeStatus(CheckModelContract $item): Item
    {
        $transformer = $this->getTransformer('InetStudio\ChecksContest\Statuses\Contracts\Transformers\Back\Resource\ShowTransformerContract');

        return $this->item($item['status'], $transformer);
    }

    /**
     * Включаем продукты в трансформацию.
     *
     * @param  CheckModelContract  $item
     *
     * @return FractalCollection
     *
     * @throws BindingResolutionException
     */
    public function includeProducts(CheckModelContract $item): FractalCollection
    {
        $transformer = $this->getTransformer('InetStudio\ChecksContest\Products\Contracts\Transformers\Back\Resource\ShowTransformerContract');

        return new FractalCollection($item['products'], $transformer);
    }

    /**
     * Включаем призы в трансформацию.
     *
     * @param  CheckModelContract  $item
     *
     * @return FractalCollection
     *
     * @throws BindingResolutionException
     */
    public function includePrizes(CheckModelContract $item): FractalCollection
    {
        $transformer = $this->getTransformer('InetStudio\ChecksContest\Prizes\Contracts\Transformers\Back\Resource\ShowTransformerContract');

        return new FractalCollection($item['prizes'], $transformer);
    }
}
