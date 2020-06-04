<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Data;

use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\DataTables\IndexServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

class GetIndexDataResponse implements GetIndexDataResponseContract
{
    protected IndexServiceContract $dataService;

    public function __construct(IndexServiceContract $dataService)
    {
        $this->dataService = $dataService;
    }

    public function toResponse($request)
    {
        return $this->dataService->ajax();
    }
}
