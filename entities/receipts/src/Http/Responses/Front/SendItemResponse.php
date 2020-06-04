<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Front;

use Illuminate\Http\Request;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SendItemResponseContract;

/**
 * Class SendItemResponse.
 */
class SendItemResponse implements SendItemResponseContract
{
    /**
     * @var ReceiptModelContract
     */
    protected $item;

    /**
     * SendReceiptResponse constructor.
     *
     * @param  ReceiptModelContract  $item
     */
    public function __construct(ReceiptModelContract $item)
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
