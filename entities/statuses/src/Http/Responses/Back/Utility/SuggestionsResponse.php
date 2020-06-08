<?php

namespace InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Utility;

use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

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

        return resolve(
            'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Utility\Suggestions\ItemsCollectionContract',
            compact('resource', 'type')
        );
    }
}
