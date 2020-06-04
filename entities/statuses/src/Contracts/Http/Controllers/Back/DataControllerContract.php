<?php

namespace InetStudio\ReceiptsContest\Statuses\Contracts\Http\Controllers\Back;

use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

interface DataControllerContract
{
    public function getIndexData(GetIndexDataRequestContract $request, GetIndexDataResponseContract $response): GetIndexDataResponseContract;
}
