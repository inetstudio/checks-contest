<?php

namespace InetStudio\ChecksContest\Statuses\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ChecksContest\Statuses\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract
{
    /**
     * @var StatusModelContract
     */
    protected $item;

    /**
     * SaveResponse constructor.
     *
     * @param  StatusModelContract  $item
     */
    public function __construct(StatusModelContract $item)
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
            'back.checks-contest.statuses.edit',
            [
                $item['id'],
            ]
        );
    }
}
