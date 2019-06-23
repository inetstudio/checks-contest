<?php

namespace InetStudio\ChecksContest\Prizes\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ChecksContest\Prizes\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract
{
    /**
     * @var PrizeModelContract
     */
    protected $item;

    /**
     * SaveResponse constructor.
     *
     * @param  PrizeModelContract  $item
     */
    public function __construct(PrizeModelContract $item)
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
            'back.checks-contest.prizes.edit',
            [
                $item['id'],
            ]
        );
    }
}
