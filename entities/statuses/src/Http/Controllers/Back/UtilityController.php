<?php

namespace InetStudio\ReceiptsContest\Statuses\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Controllers\Back\UtilityControllerContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Utility\SuggestionsRequestContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

class UtilityController extends Controller implements UtilityControllerContract
{
    public function getSuggestions(SuggestionsRequestContract $request, SuggestionsResponseContract $response): SuggestionsResponseContract
    {
        return $response;
    }
}
