<?php

namespace InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Front;

use Illuminate\Http\Request;
use InetStudio\ChecksContest\Checks\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Requests\Front\SaveItemRequestContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Front\SearchResponseContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Front\SendItemResponseContract;

/**
 * Interface ItemsControllerContract.
 */
interface ItemsControllerContract
{
    /**
     * Отправлен чек для участия в конкурсе.
     *
     * @param  ItemsServiceContract  $checksService
     * @param  SaveItemRequestContract  $request
     *
     * @return SendItemResponseContract
     */
    public function send(ItemsServiceContract $checksService, SaveItemRequestContract $request): SendItemResponseContract;

    /**
     * Поиск чека победителя.
     *
     * @param  ItemsServiceContract  $checksService
     * @param  Request  $request
     * @param  string  $field
     * @param  string  $type
     *
     * @return SearchResponseContract
     */
    public function search(ItemsServiceContract $checksService, Request $request, string $field, string $type): SearchResponseContract;
}
