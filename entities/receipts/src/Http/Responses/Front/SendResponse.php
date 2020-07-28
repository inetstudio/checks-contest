<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Front;

use InetStudio\ReceiptsContest\Receipts\DTO\Front\SendItemData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SendResponseContract;

class SendResponse implements SendResponseContract
{
    protected ItemsServiceContract $itemsService;

    public function __construct(ItemsServiceContract $itemsService)
    {
        $this->itemsService = $itemsService;
    }

    public function toResponse($request)
    {
        $data = SendItemData::fromRequest($request);

        $item = $this->itemsService->send($data);

        return response()->json(
            [
                'success' => isset($item),
                'message' => (isset($item))
                    ? trans('receipts-contest.receipts::messages.send_success')
                    : trans('receipts-contest.receipts::messages.send_fail'),
            ]
        );
    }
}
