<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Front;

use League\Fractal\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SearchResponseContract;

/**
 * Class SearchResponse.
 */
class SearchResponse implements SearchResponseContract
{
    /**
     * @var Collection
     */
    protected $items;

    /**
     * SearchResponse constructor.
     *
     * @param  Collection  $items
     */
    public function __construct(Collection $items)
    {
        $this->items = $items;
    }

    /**
     * Возвращаем результаты поиска.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     *
     * @throws BindingResolutionException
     */
    public function toResponse($request)
    {
        $transformer = app()->make(
            'InetStudio\ReceiptsContest\Receipts\Contracts\Transformers\Front\SearchItemTransformerContract'
        );

        $resource = $transformer->transformCollection($this->items);

        $serializer = app()->make('InetStudio\AdminPanel\Base\Contracts\Serializers\SimpleDataArraySerializerContract');

        $manager = new Manager();
        $manager->setSerializer($serializer);

        $transformation = $manager->createData($resource)->toArray();

        return response()->json($transformation);
    }
}
