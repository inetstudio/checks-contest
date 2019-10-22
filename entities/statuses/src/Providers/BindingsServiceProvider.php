<?php

namespace InetStudio\ChecksContest\Statuses\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * @var  array
     */
    public $bindings = [
        'InetStudio\ChecksContest\Statuses\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\ChecksContest\Statuses\Events\Back\ModifyItemEvent',
        'InetStudio\ChecksContest\Statuses\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\ChecksContest\Statuses\Http\Controllers\Back\ResourceController',
        'InetStudio\ChecksContest\Statuses\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\ChecksContest\Statuses\Http\Controllers\Back\DataController',
        'InetStudio\ChecksContest\Statuses\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\ChecksContest\Statuses\Http\Controllers\Back\UtilityController',
        'InetStudio\ChecksContest\Statuses\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\ChecksContest\Statuses\Http\Requests\Back\SaveItemRequest',
        'InetStudio\ChecksContest\Statuses\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\ChecksContest\Statuses\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\ChecksContest\Statuses\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\ChecksContest\Statuses\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\ChecksContest\Statuses\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ChecksContest\Statuses\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ChecksContest\Statuses\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\ChecksContest\Statuses\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\ChecksContest\Statuses\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\ChecksContest\Statuses\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract' => 'InetStudio\ChecksContest\Statuses\Models\StatusModel',
        'InetStudio\ChecksContest\Statuses\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\ChecksContest\Statuses\Services\Back\DataTableService',
        'InetStudio\ChecksContest\Statuses\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\ChecksContest\Statuses\Services\Back\ItemsService',
        'InetStudio\ChecksContest\Statuses\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\ChecksContest\Statuses\Services\Back\UtilityService',
        'InetStudio\ChecksContest\Statuses\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\ChecksContest\Statuses\Services\Front\ItemsService',
        'InetStudio\ChecksContest\Statuses\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\ChecksContest\Statuses\Transformers\Back\Resource\IndexTransformer',
        'InetStudio\ChecksContest\Statuses\Contracts\Transformers\Back\Resource\ShowTransformerContract' => 'InetStudio\ChecksContest\Statuses\Transformers\Back\Resource\ShowTransformer',
        'InetStudio\ChecksContest\Statuses\Contracts\Transformers\Back\Utility\SuggestionTransformerContract' => 'InetStudio\ChecksContest\Statuses\Transformers\Back\Utility\SuggestionTransformer',
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
