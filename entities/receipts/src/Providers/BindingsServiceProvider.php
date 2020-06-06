<?php

namespace InetStudio\ReceiptsContest\Receipts\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public array $bindings = [
        'InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\AttachFnsReceiptsCommandContract' => 'InetStudio\ReceiptsContest\Receipts\Console\Commands\AttachFnsReceiptsCommand',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\ModerateCommandContract' => 'InetStudio\ReceiptsContest\Receipts\Console\Commands\ModerateCommand',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\SetWinnerCommandContract' => 'InetStudio\ReceiptsContest\Receipts\Console\Commands\SetWinnerCommand',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\RecognizeCodesCommandContract' => 'InetStudio\ReceiptsContest\Receipts\Console\Commands\RecognizeCodesCommand',

        'InetStudio\ReceiptsContest\Receipts\Contracts\DTO\ItemDataContract' => 'InetStudio\ReceiptsContest\Receipts\DTO\ItemData',
        'InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Front\SendItemDataContract' => 'InetStudio\ReceiptsContest\Receipts\DTO\Front\SendItemData',

        'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\ReceiptsContest\Receipts\Events\Back\ModifyItemEvent',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\ModerateItemEventContract' => 'InetStudio\ReceiptsContest\Receipts\Events\Back\ModerateItemEvent',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Back\SetWinnerEventContract' => 'InetStudio\ReceiptsContest\Receipts\Events\Back\SetWinnerEvent',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Events\Front\SendItemEventContract' => 'InetStudio\ReceiptsContest\Receipts\Events\Front\SendItemEvent',

        'InetStudio\ReceiptsContest\Receipts\Contracts\Exports\ItemsExportContract' => 'InetStudio\ReceiptsContest\Receipts\Exports\ItemsExport',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Exports\ItemsFullExportContract' => 'InetStudio\ReceiptsContest\Receipts\Exports\ItemsFullExport',

        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Controllers\Back\ResourceController',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Controllers\Back\DataController',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Back\ExportControllerContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Controllers\Back\ExportController',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Back\ModerateControllerContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Controllers\Back\ModerateController',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Front\ItemsControllerContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Controllers\Front\ItemsController',

        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Data\GetIndexDataRequestContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Requests\Back\Data\GetIndexDataRequest',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Export\ExportItemsFullRequestContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Requests\Back\Export\ExportItemsFullRequest',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Export\ExportItemsRequestContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Requests\Back\Export\ExportItemsRequest',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Moderation\ModerateRequestContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Requests\Back\Moderation\ModerateRequest',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\DestroyRequestContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Requests\Back\Resource\DestroyRequest',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\IndexRequestContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Requests\Back\Resource\IndexRequest',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\ShowRequestContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Requests\Back\Resource\ShowRequest',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\StoreRequestContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Requests\Back\Resource\StoreRequest',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Back\Resource\UpdateRequestContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Requests\Back\Resource\UpdateRequest',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Front\SearchRequestContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Requests\Front\SearchRequest',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Requests\Front\SendRequestContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Requests\Front\SendRequest',

        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Moderation\ItemResourceContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Resources\Back\Moderation\ItemResource',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Moderation\ItemsCollectionContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Resources\Back\Moderation\ItemsCollection',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Resource\Index\ItemResourceContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Resources\Back\Resource\Index\ItemResource',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Resources\Back\Resource\Show\ItemResource',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Front\Search\ItemResourceContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Resources\Front\Search\ItemResource',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Front\Search\ItemsCollectionContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Resources\Front\Search\ItemsCollection',

        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Data\GetIndexDataResponse',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Export\ExportItemsFullResponseContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Export\ExportItemsFullResponse',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Export\ExportItemsResponseContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Export\ExportItemsResponse',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Moderation\ModerateResponseContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Moderation\ModerateResponse',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\StoreResponseContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Resource\StoreResponse',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Back\Resource\UpdateResponseContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Responses\Back\Resource\UpdateResponse',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SearchResponseContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Responses\Front\SearchResponse',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Responses\Front\SendResponseContract' => 'InetStudio\ReceiptsContest\Receipts\Http\Responses\Front\SendResponse',

        'InetStudio\ReceiptsContest\Receipts\Contracts\Listeners\Back\SetWinnerListenerContract' => 'InetStudio\ReceiptsContest\Receipts\Listeners\Back\SetWinnerListener',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Listeners\ItemStatusChangeListenerContract' => 'InetStudio\ReceiptsContest\Receipts\Listeners\ItemStatusChangeListener',

        'InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract' => 'InetStudio\ReceiptsContest\Receipts\Models\ReceiptModel',

        'InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\DataTables\IndexServiceContract' => 'InetStudio\ReceiptsContest\Receipts\Services\Back\DataTables\IndexService',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\ReceiptsContest\Receipts\Services\Back\ItemsService',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ModerateServiceContract' => 'InetStudio\ReceiptsContest\Receipts\Services\Back\ModerateService',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\ReceiptsContest\Receipts\Services\Front\ItemsService',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Services\ItemsServiceContract' => 'InetStudio\ReceiptsContest\Receipts\Services\ItemsService',

        'InetStudio\ReceiptsContest\Receipts\Contracts\Transformers\Back\Common\PreviewTransformerContract' => 'InetStudio\ReceiptsContest\Receipts\Transformers\Back\Common\PreviewTransformer',
        'InetStudio\ReceiptsContest\Receipts\Contracts\Transformers\Back\Resource\ShowTransformerContract' => 'InetStudio\ReceiptsContest\Receipts\Transformers\Back\Resource\ShowTransformer',
    ];

    public function provides()
    {
        return array_keys($this->bindings);
    }
}
