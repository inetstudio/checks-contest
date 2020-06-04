<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\DataTables\IndexServiceContract as DataTableServiceContract;

class IndexResponse implements IndexResponseContract
{
    protected DataTableServiceContract $datatableService;

    public function __construct(DataTableServiceContract $datatableService)
    {
        $this->datatableService = $datatableService;
    }

    public function toResponse($request)
    {
        $table = $this->datatableService->html();

        return view('admin.module.receipts-contest.receipts::back.pages.index', compact('table'));
    }
}
