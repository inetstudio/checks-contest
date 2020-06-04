<?php

namespace InetStudio\ReceiptsContest\Prizes\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public array $bindings = [
        'InetStudio\ReceiptsContest\Prizes\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\ReceiptsContest\Prizes\Events\Back\ModifyItemEvent',
        'InetStudio\ReceiptsContest\Prizes\Contracts\DTO\ItemDataContract' => 'InetStudio\ReceiptsContest\Prizes\DTO\ItemData',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Controllers\Back\ResourceController',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Controllers\Back\DataController',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Controllers\Back\UtilityController',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Requests\Back\Data\GetIndexDataRequest',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\CreateRequestContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Requests\Back\Resource\CreateRequest',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\DestroyRequestContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Requests\Back\Resource\DestroyRequest',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\EditRequestContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Requests\Back\Resource\EditRequest',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\IndexRequestContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Requests\Back\Resource\IndexRequest',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\ShowRequestContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Requests\Back\Resource\ShowRequest',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\StoreRequestContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Requests\Back\Resource\StoreRequest',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Resource\UpdateRequestContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Requests\Back\Resource\UpdateRequest',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Requests\Back\Utility\SuggestionsRequestContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Requests\Back\Utility\SuggestionsRequest',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Resources\Back\Resource\Index\ItemResourceContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Resources\Back\Resource\Index\ItemResource',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Resources\Back\Utility\Suggestions\AutocompleteItemResourceContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Resources\Back\Utility\Suggestions\AutocompleteItemResource',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Resources\Back\Utility\Suggestions\ItemResourceContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Resources\Back\Utility\Suggestions\ItemResource',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Resources\Back\Utility\Suggestions\ItemsCollectionContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Resources\Back\Utility\Suggestions\ItemsCollection',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Data\GetIndexDataResponse',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\CreateResponseContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource\CreateResponse',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\EditResponseContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource\EditResponse',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\StoreResponseContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource\StoreResponse',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Resource\UpdateResponseContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Resource\UpdateResponse',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\ReceiptsContest\Prizes\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract' => 'InetStudio\ReceiptsContest\Prizes\Models\PrizeModel',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\DataTables\IndexServiceContract' => 'InetStudio\ReceiptsContest\Prizes\Services\Back\DataTables\IndexService',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\ReceiptsContest\Prizes\Services\Back\ItemsService',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\ReceiptsContest\Prizes\Services\Back\UtilityService',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\ReceiptsContest\Prizes\Services\Front\ItemsService',
        'InetStudio\ReceiptsContest\Prizes\Contracts\Services\ItemsServiceContract' => 'InetStudio\ReceiptsContest\Prizes\Services\ItemsService',
    ];

    public function provides()
    {
        return array_keys($this->bindings);
    }
}
