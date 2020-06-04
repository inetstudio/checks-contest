<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Moderation;

use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ModerateServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Moderation\ModerateResponseContract;

class ModerateResponse implements ModerateResponseContract
{
    protected ModerateServiceContract $moderateService;

    public function __construct(ModerateServiceContract $moderateService)
    {
        $this->moderateService = $moderateService;
    }

    public function toResponse($request)
    {
        $id = $request->route('id', 0);
        $alias = $request->route('alias', '');
        $data = $request->input('additional_info', []);

        $resource = $this->moderateService->moderate($id, $alias, $data);

        return app()->make(
            'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Moderation\ItemsCollectionContract',
            compact('resource')
        );
    }
}
