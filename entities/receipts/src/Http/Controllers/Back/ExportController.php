<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Back\ExportControllerContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Export\ExportItemsRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Export\ExportItemsResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Export\ExportItemsFullRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Export\ExportItemsFullResponseContract;

class ExportController extends Controller implements ExportControllerContract
{
    public function exportItems(ExportItemsRequestContract $request, ExportItemsResponseContract $response): ExportItemsResponseContract
    {
        return $response;
    }

    public function exportItemsFull(ExportItemsFullRequestContract $request, ExportItemsFullResponseContract $response): ExportItemsFullResponseContract
    {
        return $response;
    }
}
