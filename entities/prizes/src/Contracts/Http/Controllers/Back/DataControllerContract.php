<?php

namespace InetStudio\ChecksContest\Prizes\Contracts\Http\Controllers\Back;

use Illuminate\Http\JsonResponse;
use InetStudio\ChecksContest\Prizes\Contracts\Services\Back\DataTableServiceContract;

/**
 * Interface DataControllerContract.
 */
interface DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param  DataTableServiceContract  $dataTableService
     *
     * @return JsonResponse
     */
    public function data(DataTableServiceContract $dataTableService): JsonResponse;
}
