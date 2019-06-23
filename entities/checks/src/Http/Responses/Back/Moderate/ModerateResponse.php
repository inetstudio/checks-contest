<?php

namespace InetStudio\ChecksContest\Checks\Http\Responses\Back\Moderate;

use Throwable;
use Illuminate\Http\Request;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Moderate\ModerateResponseContract;

/**
 * Class ModerateResponse.
 */
class ModerateResponse implements ModerateResponseContract
{
    /**
     * @var bool
     */
    protected $result;

    /**
     * @var CheckModelContract
     */
    protected $item;

    /**
     * ModerateResponse constructor.
     *
     * @param  bool  $result
     * @param  CheckModelContract  $item
     */
    public function __construct(bool $result, CheckModelContract $item)
    {
        $this->result = $result;
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при модерации объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     *
     * @throws Throwable
     */
    public function toResponse($request)
    {
        $responseData = ($this->result) ? [
            'success' => true,
            'status' => view(
                'admin.module.checks-contest.checks::back.partials.datatables.status',
                [
                    'item' => $this->item['status'],
                ]
            )->render(),
            'moderation' => view(
                'admin.module.checks-contest.checks::back.partials.datatables.moderation',
                [
                    'item' => $this->item,
                ]
            )->render(),
        ] : [
            'success' => false,
        ];

        return response()->json($responseData);
    }
}
