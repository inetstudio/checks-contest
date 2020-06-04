<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\DataTables\IndexServiceContract as DataTableServiceContract;

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

        return view('admin.module.receipts-contest.prizes::back.pages.index', compact('table'));
    }
}
