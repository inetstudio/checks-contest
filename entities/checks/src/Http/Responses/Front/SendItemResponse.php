<?php

namespace InetStudio\ChecksContest\Checks\Http\Responses\Front;

use Illuminate\Http\Request;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Front\SendItemResponseContract;

/**
 * Class SendItemResponse.
 */
class SendItemResponse implements SendItemResponseContract
{
    /**
     * @var CheckModelContract
     */
    protected $item;

    /**
     * SendCheckResponse constructor.
     *
     * @param  CheckModelContract  $item
     */
    public function __construct(CheckModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при отправке чека.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'success' => true,
                'message' => 'Ваш чек отправлен на модерацию.',
            ]
        );
    }
}
