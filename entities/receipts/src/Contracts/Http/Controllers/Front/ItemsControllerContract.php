<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Front;

use Illuminate\Http\Request;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Front\SaveItemRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SearchResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SendItemResponseContract;

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
