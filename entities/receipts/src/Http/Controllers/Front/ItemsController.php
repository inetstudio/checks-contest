<?php

namespace InetStudio\ReceiptsContest\Receipts\Http\Controllers\Front;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Front\SaveItemRequestContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SearchResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SendItemResponseContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Front\ItemsControllerContract;

/**
 * Class ItemsController.
 */
class ItemsController extends Controller implements ItemsControllerContract
{
    /**
     * Отправление чека для участия в конкурсе.
     *
     * @param  ItemsServiceContract  $checksService
     * @param  SaveItemRequestContract  $request
     *
     * @return SendItemResponseContract
     *
     * @throws BindingResolutionException
     */
    public function send(ItemsServiceContract $checksService, SaveItemRequestContract $request): SendItemResponseContract
    {
        $data = $request->all();

        $item = $checksService->send($data);

        return $this->app->make(SendItemResponseContract::class, compact('item'));
    }

    /**
     * Поиск чека.
     *
     * @param  ItemsServiceContract  $checksService
     * @param  Request  $request
     * @param  string  $field
     * @param  string  $type
     *
     * @return SearchResponseContract
     *
     * @throws BindingResolutionException
     */
    public function search(ItemsServiceContract $checksService, Request $request, string $field, string $type): SearchResponseContract
    {
        $search = $request->get('query', '') ?? '';

        $items = $checksService->search($field, $search, $type);

        return $this->app->make(SearchResponseContract::class, compact('items'));
    }
}
