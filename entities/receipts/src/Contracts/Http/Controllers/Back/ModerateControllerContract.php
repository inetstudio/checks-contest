<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Back;

use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Moderation\ModerateRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Moderation\ModerateResponseContract;

interface ModerateControllerContract
{
    public function moderate(ModerateRequestContract $request, ModerateResponseContract $response): ModerateResponseContract;
}
