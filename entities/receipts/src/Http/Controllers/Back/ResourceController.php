<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\ShowRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Back\ResourceControllerContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\IndexRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\ShowResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\UpdateRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\DestroyRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\UpdateResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

class ResourceController extends Controller implements ResourceControllerContract
{
    public function index(IndexRequestContract $request, IndexResponseContract $response): IndexResponseContract
    {
        return $response;
    }

    public function show(ShowRequestContract $request, ShowResponseContract $response): ShowResponseContract
    {
        return $response;
    }

    public function update(UpdateRequestContract $request, UpdateResponseContract $response): UpdateResponseContract
    {
        return $response;
    }

    public function destroy(DestroyRequestContract $request, DestroyResponseContract $response): DestroyResponseContract
    {
        return $response;
    }
}
