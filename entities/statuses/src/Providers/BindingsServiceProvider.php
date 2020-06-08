<?php

namespace InetStudio\ReceiptsContest\Statuses\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public array $bindings = [
        'InetStudio\ReceiptsContest\Statuses\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\ReceiptsContest\Statuses\Events\Back\ModifyItemEvent',

        'InetStudio\ReceiptsContest\Statuses\Contracts\DTO\Back\Resource\Save\ItemDataContract' => 'InetStudio\ReceiptsContest\Statuses\DTO\Back\Resource\Save\ItemData',

        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Controllers\Back\ResourceController',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Controllers\Back\DataController',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Controllers\Back\UtilityController',

        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Requests\Back\Data\GetIndexDataRequest',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Resource\CreateRequestContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Requests\Back\Resource\CreateRequest',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Resource\DestroyRequestContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Requests\Back\Resource\DestroyRequest',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Resource\EditRequestContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Requests\Back\Resource\EditRequest',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Resource\IndexRequestContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Requests\Back\Resource\IndexRequest',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Resource\ShowRequestContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Requests\Back\Resource\ShowRequest',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Resource\StoreRequestContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Requests\Back\Resource\StoreRequest',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Resource\UpdateRequestContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Requests\Back\Resource\UpdateRequest',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Requests\Back\Utility\GetSuggestionsRequestContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Requests\Back\Utility\GetSuggestionsRequest',

        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Resource\Index\ItemResourceContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Resources\Back\Resource\Index\ItemResource',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Resources\Back\Resource\Show\ItemResource',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Utility\Suggestions\AutocompleteItemResourceContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Resources\Back\Utility\Suggestions\AutocompleteItemResource',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Utility\Suggestions\ItemResourceContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Resources\Back\Utility\Suggestions\ItemResource',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Utility\Suggestions\ItemsCollectionContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Resources\Back\Utility\Suggestions\ItemsCollection',

        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Data\GetIndexDataResponse',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Resource\CreateResponseContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Resource\CreateResponse',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Resource\EditResponseContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Resource\EditResponse',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Resource\StoreResponseContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Resource\StoreResponse',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Resource\UpdateResponseContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Resource\UpdateResponse',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Responses\Back\Utility\GetSuggestionsResponseContract' => 'InetStudio\ReceiptsContest\Statuses\Http\Responses\Back\Utility\GetSuggestionsResponse',

        'InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract' => 'InetStudio\ReceiptsContest\Statuses\Models\StatusModel',

        'InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\DataTables\IndexServiceContract' => 'InetStudio\ReceiptsContest\Statuses\Services\Back\DataTables\IndexService',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\ReceiptsContest\Statuses\Services\Back\ItemsService',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ResourceServiceContract' => 'InetStudio\ReceiptsContest\Statuses\Services\Back\ResourceService',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\ReceiptsContest\Statuses\Services\Back\UtilityService',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\ReceiptsContest\Statuses\Services\Front\ItemsService',
        'InetStudio\ReceiptsContest\Statuses\Contracts\Services\ItemsServiceContract' => 'InetStudio\ReceiptsContest\Statuses\Services\ItemsService',
    ];

    public function provides()
    {
        return array_keys($this->bindings);
    }
}
