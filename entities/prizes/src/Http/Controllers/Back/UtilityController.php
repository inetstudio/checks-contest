<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Controllers\Back\UtilityControllerContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Utility\GetSuggestionsRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Utility\GetSuggestionsResponseContract;

class UtilityController extends Controller implements UtilityControllerContract
{
    public function getSuggestions(GetSuggestionsRequestContract $request, GetSuggestionsResponseContract $response): GetSuggestionsResponseContract
    {
        return $response;
    }
}
