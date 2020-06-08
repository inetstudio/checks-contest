<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Back;

use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\ShowRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\IndexRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\ShowResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\UpdateRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\DestroyRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\UpdateResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

interface ResourceControllerContract
{
    public function index(IndexRequestContract $request, IndexResponseContract $response): IndexResponseContract;

    public function show(ShowRequestContract $request, ShowResponseContract $response): ShowResponseContract;

    public function update(UpdateRequestContract $request, UpdateResponseContract $response): UpdateResponseContract;

    public function destroy(DestroyRequestContract $request, DestroyResponseContract $response): DestroyResponseContract;
}
