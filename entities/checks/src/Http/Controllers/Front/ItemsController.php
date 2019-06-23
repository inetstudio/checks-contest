<?php

namespace InetStudio\ChecksContest\Checks\Http\Controllers\Front;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Requests\Front\SaveItemRequestContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Front\SearchResponseContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Front\SendItemResponseContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Front\ItemsControllerContract;

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
     * Поиск чека победителя.
     *
     * @param  ItemsServiceContract  $checksService
     * @param  Request  $request
     * @param  string  $field
     *
     * @return SearchResponseContract
     *
     * @throws BindingResolutionException
     */
    public function search(ItemsServiceContract $checksService, Request $request, string $field): SearchResponseContract
    {
        $search = $request->get('query', '') ?? '';

        $items = $checksService->search($field, $search);

        return $this->app->make(SearchResponseContract::class, compact('items'));
    }
}
