<?php

namespace InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\DataTables\IndexServiceContract as DataTableServiceContract;

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

        return view('admin.module.receipts-contest.statuses::back.pages.index', compact('table'));
    }
}
