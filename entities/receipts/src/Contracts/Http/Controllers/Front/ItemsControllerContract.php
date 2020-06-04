<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Front;

use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Front\SendRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Front\SearchRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SendResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SearchResponseContract;

interface ItemsControllerContract
{
    public function send(SendRequestContract $request, SendResponseContract $response): SendResponseContract;

    public function search(SearchRequestContract $request, SearchResponseContract $response): SearchResponseContract;
}
