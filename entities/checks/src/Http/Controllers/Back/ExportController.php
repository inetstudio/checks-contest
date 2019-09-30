<?php

namespace InetStudio\ChecksContest\Checks\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use PhpOffice\PhpSpreadsheet\Writer\Exception as PhpOfficeException;
use InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Back\ExportControllerContract;

/**
 * Class ExportController.
 */
class ExportController extends Controller implements ExportControllerContract
{
    /**
     * Выгружаем объекты.
     *
     * @return BinaryFileResponse
     *
     * @throws BindingResolutionException
     */
    public function exportItems(): BinaryFileResponse
    {
        $export = app()->make('InetStudio\ChecksContest\Checks\Contracts\Exports\ItemsExportContract');

        return Excel::download($export, time().'.xlsx');
    }

    /**
     * Выгружаем объекты.
     *
     * @return BinaryFileResponse
     *
     * @throws BindingResolutionException
     */
    public function exportFullItems(): BinaryFileResponse
    {
        $export = app()->make('InetStudio\ChecksContest\Checks\Contracts\Exports\ItemsFullExportContract');

        return Excel::download($export, time().'.xlsx');
    }
}
