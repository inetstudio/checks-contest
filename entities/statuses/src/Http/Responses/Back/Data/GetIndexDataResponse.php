<?php

namespace InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Data;

use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\DataTables\IndexServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

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
