<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Data;

use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\DataTables\IndexServiceContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

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
