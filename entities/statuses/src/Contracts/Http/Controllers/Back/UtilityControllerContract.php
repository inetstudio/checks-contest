<?php

namespace InetStudio\ReceiptsContest\Statuses\Contracts\Http\Controllers\Back;

use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Utility\GetSuggestionsRequestContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Utility\GetSuggestionsResponseContract;

interface UtilityControllerContract
{
    public function getSuggestions(GetSuggestionsRequestContract $request, GetSuggestionsResponseContract $response): GetSuggestionsResponseContract;
}
