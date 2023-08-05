<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Controllers\Front;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Front\SendRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Front\SearchRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SearchResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SendResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Front\ItemsControllerContract;
use InetStudio\ReceiptsContest\Receipts\Http\Requests\Front\GetWinnersRequest;
use InetStudio\ReceiptsContest\Receipts\Http\Responses\Front\GetWinnersResponse;

class ItemsController extends Controller implements ItemsControllerContract
{
    public function send(SendRequestContract $request, SendResponseContract $response): SendResponseContract
    {
        return $response;
    }

    public function search(SearchRequestContract $request, SearchResponseContract $response): SearchResponseContract
    {
        return $response;
    }

    public function getWinners(GetWinnersRequest $request, GetWinnersResponse $response): GetWinnersResponse
    {
        return $response;
    }
}
