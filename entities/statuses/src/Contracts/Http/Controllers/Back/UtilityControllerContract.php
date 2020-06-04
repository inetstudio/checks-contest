<?php

namespace InetStudio\ReceiptsContest\Statuses\Contracts\Http\Controllers\Back;

use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Utility\SuggestionsRequestContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

interface UtilityControllerContract
{
    public function getSuggestions(SuggestionsRequestContract $request, SuggestionsResponseContract $response): SuggestionsResponseContract;
}
