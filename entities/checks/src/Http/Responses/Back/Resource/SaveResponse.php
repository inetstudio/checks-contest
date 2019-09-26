<?php

namespace InetStudio\ChecksContest\Checks\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract
{
    /**
     * @var CheckModelContract
     */
    protected $item;

    /**
     * SaveResponse constructor.
     *
     * @param  CheckModelContract  $item
     */
    public function __construct(CheckModelContract $item)
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

        if ($request->ajax()) {
            return response()->json(
                [
                    'success' => true,
                    'item' => $item,
                ],
                200
            );
        } else {
            return response()->redirectToRoute(
                'back.checks-contest.checks.edit',
                [
                    $item['id'],
                ]
            );
        }
    }
}
