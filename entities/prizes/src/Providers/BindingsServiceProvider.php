<?php

namespace InetStudio\ChecksContest\Prizes\Providers;

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
        'InetStudio\ChecksContest\Prizes\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\ChecksContest\Prizes\Events\Back\ModifyItemEvent',
        'InetStudio\ChecksContest\Prizes\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\ChecksContest\Prizes\Http\Controllers\Back\ResourceController',
        'InetStudio\ChecksContest\Prizes\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\ChecksContest\Prizes\Http\Controllers\Back\DataController',
        'InetStudio\ChecksContest\Prizes\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\ChecksContest\Prizes\Http\Controllers\Back\UtilityController',
        'InetStudio\ChecksContest\Prizes\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\ChecksContest\Prizes\Http\Requests\Back\SaveItemRequest',
        'InetStudio\ChecksContest\Prizes\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\ChecksContest\Prizes\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\ChecksContest\Prizes\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\ChecksContest\Prizes\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\ChecksContest\Prizes\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ChecksContest\Prizes\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ChecksContest\Prizes\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\ChecksContest\Prizes\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\ChecksContest\Prizes\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\ChecksContest\Prizes\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract' => 'InetStudio\ChecksContest\Prizes\Models\PrizeModel',
        'InetStudio\ChecksContest\Prizes\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\ChecksContest\Prizes\Services\Back\DataTableService',
        'InetStudio\ChecksContest\Prizes\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\ChecksContest\Prizes\Services\Back\ItemsService',
        'InetStudio\ChecksContest\Prizes\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\ChecksContest\Prizes\Services\Back\UtilityService',
        'InetStudio\ChecksContest\Prizes\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\ChecksContest\Prizes\Services\Front\ItemsService',
        'InetStudio\ChecksContest\Prizes\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\ChecksContest\Prizes\Transformers\Back\Resource\IndexTransformer',
        'InetStudio\ChecksContest\Prizes\Contracts\Transformers\Back\Utility\SuggestionTransformerContract' => 'InetStudio\ChecksContest\Prizes\Transformers\Back\Utility\SuggestionTransformer',
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
