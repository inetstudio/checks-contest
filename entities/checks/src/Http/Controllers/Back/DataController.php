<?php

namespace InetStudio\ChecksContest\Checks\Http\Controllers\Back;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use InetStudio\ChecksContest\Checks\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Back\DataControllerContract;

/**
 * Class DataController.
 */
class DataController extends Controller implements DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param  DataTableServiceContract  $dataTableService
     *
     * @return JsonResponse
     */
    public function data(DataTableServiceContract $dataTableService): JsonResponse
    {
        return $dataTableService->ajax();
    }
}
