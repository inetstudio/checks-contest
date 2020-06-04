<?php

namespace InetStudio\ReceiptsContest\Prizes\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Controllers\Back\UtilityControllerContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Utility\SuggestionsRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

class UtilityController extends Controller implements UtilityControllerContract
{
    public function getSuggestions(SuggestionsRequestContract $request, SuggestionsResponseContract $response): SuggestionsResponseContract
    {
        return $response;
    }
}
