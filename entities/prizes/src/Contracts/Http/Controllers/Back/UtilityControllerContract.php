<?php

namespace InetStudio\ReceiptsContest\Prizes\Contracts\Http\Controllers\Back;

use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Utility\SuggestionsRequestContract;
use InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

interface UtilityControllerContract
{
    public function getSuggestions(SuggestionsRequestContract $request, SuggestionsResponseContract $response): SuggestionsResponseContract;
}
