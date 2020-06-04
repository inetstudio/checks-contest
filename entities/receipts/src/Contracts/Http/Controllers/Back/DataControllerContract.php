<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Back;

use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

interface DataControllerContract
{
    public function getIndexData(GetIndexDataRequestContract $request, GetIndexDataResponseContract $response): GetIndexDataResponseContract;
}
