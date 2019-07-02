<?php

namespace InetStudio\ChecksContest\Checks\Http\Controllers\Back;

use App\Http\Controllers\Controller;
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
     * @throws Exception
     * @throws PhpOfficeException
     */
    public function exportItems(): BinaryFileResponse
    {
        $export = app()->make('InetStudio\ChecksContest\Checks\Contracts\Exports\ItemsExportContract');

        return Excel::download($export, time().'.xlsx');
    }
}
