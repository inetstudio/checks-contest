<?php

namespace InetStudio\ReceiptsContest\Prizes\Contracts\Http\Controllers\Back;

use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\ShowRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\EditRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\IndexRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\StoreRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\CreateRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\ShowResponseContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\EditResponseContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\UpdateRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\StoreResponseContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\DestroyRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\CreateResponseContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\UpdateResponseContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

interface ResourceControllerContract
{
    public function index(IndexRequestContract $request, IndexResponseContract $response): IndexResponseContract;

    public function create(CreateRequestContract $request, CreateResponseContract $response): CreateResponseContract;

    public function store(StoreRequestContract $request, StoreResponseContract $response): StoreResponseContract;

    public function show(ShowRequestContract $request, ShowResponseContract $response): ShowResponseContract;

    public function edit(EditRequestContract $request, EditResponseContract $response): EditResponseContract;

    public function update(UpdateRequestContract $request, UpdateResponseContract $response): UpdateResponseContract;

    public function destroy(DestroyRequestContract $request, DestroyResponseContract $response): DestroyResponseContract;
}
