<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Controllers\Back\DataControllerContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

class DataController extends Controller implements DataControllerContract
{
    public function getIndexData(GetIndexDataRequestContract $request, GetIndexDataResponseContract $response): GetIndexDataResponseContract
    {
        return $response;
    }
}
