<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Export;

use Maatwebsite\Excel\Facades\Excel;
use InetStudio\ReceiptsContest\Receipts\Contracts\Exports\ItemsExportContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Export\ExportItemsResponseContract;

class ExportItemsResponse implements ExportItemsResponseContract
{
    protected ItemsExportContract $export;

    public function __construct(ItemsExportContract $export)
    {
        $this->export = $export;
    }

    public function toResponse($request)
    {
        $data = [
            'route' => $request->route()->parameters(),
            'request' => $request->all(),
        ];

        $this->export->setData($data);

        return Excel::download($this->export, time().'.xlsx');
    }
}
