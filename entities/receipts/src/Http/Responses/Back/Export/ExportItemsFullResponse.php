<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Export;

use Maatwebsite\Excel\Facades\Excel;
use InetStudio\ReceiptsContest\Receipts\Contracts\Exports\ItemsFullExportContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Export\ExportItemsFullResponseContract;

class ExportItemsFullResponse implements ExportItemsFullResponseContract
{
    protected ItemsFullExportContract $export;

    public function __construct(ItemsFullExportContract $export)
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
