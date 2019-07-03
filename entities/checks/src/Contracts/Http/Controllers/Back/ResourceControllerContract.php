<?php

namespace InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Back;

use InetStudio\ChecksContest\Checks\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ChecksContest\Checks\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Requests\Back\SaveItemRequestContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\FormResponseContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\ShowResponseContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Interface ResourceControllerContract.
 */
interface ResourceControllerContract
{
    /**
     * Список объектов.
     *
     * @param  DataTableServiceContract  $dataTableService
     *
     * @return IndexResponseContract
     */
    public function index(DataTableServiceContract $dataTableService): IndexResponseContract;

    /**
     * Редактирование объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  int  $id
     *
     * @return FormResponseContract
     */
    public function edit(ItemsServiceContract $resourceService, int $id = 0): FormResponseContract;

    /**
     * Обновление объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  SaveItemRequestContract  $request
     * @param  int  $id
     *
     * @return SaveResponseContract
     */
    public function update(
        ItemsServiceContract $resourceService,
        SaveItemRequestContract $request,
        int $id = 0
    ): SaveResponseContract;

    /**
     * Отображение объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  int  $id
     *
     * @return ShowResponseContract
     */
    public function show(ItemsServiceContract $resourceService, int $id = 0): ShowResponseContract;

    /**
     * Удаление объекта.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  int  $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(ItemsServiceContract $resourceService, int $id = 0): DestroyResponseContract;
}
