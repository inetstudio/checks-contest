<?php

namespace InetStudio\ChecksContest\Products\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract;
use InetStudio\ChecksContest\Products\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract
{
    /**
     * @var ProductModelContract
     */
    protected $item;

    /**
     * SaveResponse constructor.
     *
     * @param  ProductModelContract  $item
     */
    public function __construct(ProductModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $item = $this->item->fresh();

        return response()->redirectToRoute(
            'back.checks-contest.products.edit',
            [
                $item['id'],
            ]
        );
    }
}
