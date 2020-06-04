<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource;

use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

class DestroyResponse implements DestroyResponseContract
{
    protected ItemsServiceContract $resourceService;

    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
    }

    public function toResponse($request)
    {
        $id = $request->route('prize');

        $count = $this->resourceService->destroy($id);

        return response()->json(
            [
                'success' => ($count > 0),
            ]
        );
    }
}
