<?php

namespace InetStudio\ReceiptsContest\Prizes\Contracts\Http\Controllers\Back;

use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Utility\GetSuggestionsRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Utility\GetSuggestionsResponseContract;

interface UtilityControllerContract
{
    public function getSuggestions(GetSuggestionsRequestContract $request, GetSuggestionsResponseContract $response): GetSuggestionsResponseContract;
}
