<?php

namespace InetStudio\ChecksContest\Products\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * @var array
     */
    public $bindings = [
        'InetStudio\ChecksContest\Products\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\ChecksContest\Products\Events\Back\ModifyItemEvent',
        'InetStudio\ChecksContest\Products\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\ChecksContest\Products\Http\Controllers\Back\ResourceController',
        'InetStudio\ChecksContest\Products\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\ChecksContest\Products\Http\Controllers\Back\DataController',
        'InetStudio\ChecksContest\Products\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\ChecksContest\Products\Http\Controllers\Back\UtilityController',
        'InetStudio\ChecksContest\Products\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\ChecksContest\Products\Http\Requests\Back\SaveItemRequest',
        'InetStudio\ChecksContest\Products\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\ChecksContest\Products\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\ChecksContest\Products\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\ChecksContest\Products\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\ChecksContest\Products\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ChecksContest\Products\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ChecksContest\Products\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\ChecksContest\Products\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\ChecksContest\Products\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\ChecksContest\Products\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract' => 'InetStudio\ChecksContest\Products\Models\ProductModel',
        'InetStudio\ChecksContest\Products\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\ChecksContest\Products\Services\Back\DataTableService',
        'InetStudio\ChecksContest\Products\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\ChecksContest\Products\Services\Back\ItemsService',
        'InetStudio\ChecksContest\Products\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\ChecksContest\Products\Services\Back\UtilityService',
        'InetStudio\ChecksContest\Products\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\ChecksContest\Products\Services\Front\ItemsService',
        'InetStudio\ChecksContest\Products\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\ChecksContest\Products\Transformers\Back\Resource\IndexTransformer',
        'InetStudio\ChecksContest\Products\Contracts\Transformers\Back\Utility\SuggestionTransformerContract' => 'InetStudio\ChecksContest\Products\Transformers\Back\Utility\SuggestionTransformer',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
