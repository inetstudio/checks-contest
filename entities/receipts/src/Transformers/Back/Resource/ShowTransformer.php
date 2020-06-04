<?php

namespace InetStudio\ReceiptsContest\Receipts\Transformers\Back\Resource;

use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Transformers\Back\Resource\ShowTransformerContract;

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
     * @param  ReceiptModelContract  $item
     *
     * @return array
     */
    public function transform(ReceiptModelContract $item): array
    {
        return $item->toArray();
    }

    /**
     * Включаем превью в трансформацию.
     *
     * @param  ReceiptModelContract  $item
     *
     * @return Item
     *
     * @throws BindingResolutionException
     */
    public function includePreview(ReceiptModelContract $item): Item
    {
        $transformer = $this->getTransformer('InetStudio\ReceiptsContest\Receipts\Contracts\Transformers\Back\Common\PreviewTransformerContract');

        return $this->item($item, $transformer);
    }

    /**
     * Включаем чек ФНС в трансформацию.
     *
     * @param  ReceiptModelContract  $item
     *
     * @return Item
     *
     * @throws BindingResolutionException
     */
    public function includeFnsReceipt(ReceiptModelContract $item): Item
    {
        $transformer = $this->getTransformer('InetStudio\Fns\Receipts\Contracts\Transformers\Back\Resource\ShowTransformerContract');

        return $this->item($item['fnsReceipt'], $transformer);
    }

    /**
     * Включаем статус в трансформацию.
     *
     * @param  ReceiptModelContract  $item
     *
     * @return Item
     *
     * @throws BindingResolutionException
     */
    public function includeStatus(ReceiptModelContract $item): Item
    {
        $transformer = $this->getTransformer('InetStudio\ReceiptsContest\Statuses\Contracts\Transformers\Back\Resource\ShowTransformerContract');

        return $this->item($item['status'], $transformer);
    }

    /**
     * Включаем продукты в трансформацию.
     *
     * @param  ReceiptModelContract  $item
     *
     * @return FractalCollection
     *
     * @throws BindingResolutionException
     */
    public function includeProducts(ReceiptModelContract $item): FractalCollection
    {
        $transformer = $this->getTransformer('InetStudio\ReceiptsContest\Products\Contracts\Transformers\Back\Resource\ShowTransformerContract');

        return new FractalCollection($item['products'], $transformer);
    }

    /**
     * Включаем призы в трансформацию.
     *
     * @param  ReceiptModelContract  $item
     *
     * @return FractalCollection
     *
     * @throws BindingResolutionException
     */
    public function includePrizes(ReceiptModelContract $item): FractalCollection
    {
        $transformer = $this->getTransformer('InetStudio\ReceiptsContest\Prizes\Contracts\Transformers\Back\Resource\ShowTransformerContract');

        return new FractalCollection($item['prizes'], $transformer);
    }
}
