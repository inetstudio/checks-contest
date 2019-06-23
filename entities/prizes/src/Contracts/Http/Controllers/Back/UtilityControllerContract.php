<?php

namespace InetStudio\ChecksContest\Prizes\Contracts\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\ChecksContest\Prizes\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\ChecksContest\Prizes\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Interface UtilityControllerContract.
 */
interface UtilityControllerContract
{
    /**
     * Возвращаем объекты для поля.
     *
     * @param  UtilityServiceContract  $utilityService
     * @param  Request  $request
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(UtilityServiceContract $utilityService, Request $request): SuggestionsResponseContract;
}
