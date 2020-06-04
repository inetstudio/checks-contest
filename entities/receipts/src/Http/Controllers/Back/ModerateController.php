<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Back\ModerateControllerContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Moderation\ModerateRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Moderation\ModerateResponseContract;

class ModerateController extends Controller implements ModerateControllerContract
{
    public function moderate(ModerateRequestContract $request, ModerateResponseContract $response): ModerateResponseContract
    {
        return $response;
    }
}
