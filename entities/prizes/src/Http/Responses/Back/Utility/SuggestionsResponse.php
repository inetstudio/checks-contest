<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Utility;

use InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

class SuggestionsResponse implements SuggestionsResponseContract
{
    protected UtilityServiceContract $utilityService;

    public function __construct(UtilityServiceContract $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    public function toResponse($request)
    {
        $search = $request->get('q', '') ?? '';
        $type = $request->get('type', '') ?? '';

        $resource = $this->utilityService->getSuggestions($search);

        return app()->make(
            'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Resources\Back\Utility\Suggestions\ItemsCollectionContract',
            compact('resource', 'type')
        );
    }
}
