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

/**
 * Interface ResourceControllerContract.
 */
interface ResourceControllerContract
{
    /**
     * Список объектов.
     *
     * @param  IndexRequestContract  $request
     * @param  IndexResponseContract  $response
     *
     * @return IndexResponseContract
     */
    public function index(IndexRequestContract $request, IndexResponseContract $response): IndexResponseContract;

    /**
     * Создание объекта.
     *
     * @param  CreateRequestContract  $request
     * @param  CreateResponseContract  $response
     *
     * @return CreateResponseContract
     */
    public function create(CreateRequestContract $request, CreateResponseContract $response): CreateResponseContract;

    /**
     * Сохранение объекта.
     *
     * @param  StoreRequestContract  $request
     * @param  StoreResponseContract  $response
     *
     * @return StoreResponseContract
     */
    public function store(StoreRequestContract $request, StoreResponseContract $response): StoreResponseContract;

    /**
     * Отображение объекта.
     *
     * @param  ShowRequestContract  $request
     * @param  ShowResponseContract  $response
     *
     * @return ShowResponseContract
     */
    public function show(ShowRequestContract $request, ShowResponseContract $response): ShowResponseContract;

    /**
     * Редактирование объекта.
     *
     * @param  EditRequestContract  $request
     * @param  EditResponseContract  $response
     *
     * @return EditResponseContract
     */
    public function edit(EditRequestContract $request, EditResponseContract $response): EditResponseContract;

    /**
     * Обновление объекта.
     *
     * @param  UpdateRequestContract  $request
     * @param  UpdateResponseContract  $response
     *
     * @return UpdateResponseContract
     */
    public function update(UpdateRequestContract $request, UpdateResponseContract $response): UpdateResponseContract;

    /**
     * Удаление объекта.
     *
     * @param  DestroyRequestContract  $request
     * @param  DestroyResponseContract  $response
     *
     * @return DestroyResponseContract
     */
    public function destroy(
        DestroyRequestContract $request,
        DestroyResponseContract $response
    ): DestroyResponseContract;
}
