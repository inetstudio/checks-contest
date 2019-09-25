<?php

namespace InetStudio\ChecksContest\Checks\Providers;

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
        'InetStudio\ChecksContest\Checks\Contracts\Console\Commands\AttachFnsReceiptsCommandContract' => 'InetStudio\ChecksContest\Checks\Console\Commands\AttachFnsReceiptsCommand',
        'InetStudio\ChecksContest\Checks\Contracts\Console\Commands\ModerateChecksCommandContract' => 'InetStudio\ChecksContest\Checks\Console\Commands\ModerateChecksCommand',
        'InetStudio\ChecksContest\Checks\Contracts\Console\Commands\SetWinnerCommandContract' => 'InetStudio\ChecksContest\Checks\Console\Commands\SetWinnerCommand',
        'InetStudio\ChecksContest\Checks\Contracts\Console\Commands\RecognizeCodesCommandContract' => 'InetStudio\ChecksContest\Checks\Console\Commands\RecognizeCodesCommand',
        'InetStudio\ChecksContest\Checks\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\ChecksContest\Checks\Events\Back\ModifyItemEvent',
        'InetStudio\ChecksContest\Checks\Contracts\Events\Back\ModerateItemEventContract' => 'InetStudio\ChecksContest\Checks\Events\Back\ModerateItemEvent',
        'InetStudio\ChecksContest\Checks\Contracts\Events\Back\SetWinnerEventContract' => 'InetStudio\ChecksContest\Checks\Events\Back\SetWinnerEvent',
        'InetStudio\ChecksContest\Checks\Contracts\Events\Front\SendItemEventContract' => 'InetStudio\ChecksContest\Checks\Events\Front\SendItemEvent',
        'InetStudio\ChecksContest\Checks\Contracts\Exports\ItemsExportContract' => 'InetStudio\ChecksContest\Checks\Exports\ItemsExport',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\ChecksContest\Checks\Http\Controllers\Back\ResourceController',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\ChecksContest\Checks\Http\Controllers\Back\DataController',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Back\ExportControllerContract' => 'InetStudio\ChecksContest\Checks\Http\Controllers\Back\ExportController',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Back\ModerateControllerContract' => 'InetStudio\ChecksContest\Checks\Http\Controllers\Back\ModerateController',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Front\ItemsControllerContract' => 'InetStudio\ChecksContest\Checks\Http\Controllers\Front\ItemsController',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\ChecksContest\Checks\Http\Requests\Back\SaveItemRequest',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Requests\Front\SaveItemRequestContract' => 'InetStudio\ChecksContest\Checks\Http\Requests\Front\SaveItemRequest',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Moderate\ModerateResponseContract' => 'InetStudio\ChecksContest\Checks\Http\Responses\Back\Moderate\ModerateResponse',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\ChecksContest\Checks\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\ChecksContest\Checks\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\ChecksContest\Checks\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\ChecksContest\Checks\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\ChecksContest\Checks\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Front\SendItemResponseContract' => 'InetStudio\ChecksContest\Checks\Http\Responses\Front\SendItemResponse',
        'InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Front\SearchResponseContract' => 'InetStudio\ChecksContest\Checks\Http\Responses\Front\SearchResponse',
        'InetStudio\ChecksContest\Checks\Contracts\Listeners\Back\SetWinnerListenerContract' => 'InetStudio\ChecksContest\Checks\Listeners\Back\SetWinnerListener',
        'InetStudio\ChecksContest\Checks\Contracts\Listeners\ItemStatusChangeListenerContract' => 'InetStudio\ChecksContest\Checks\Listeners\ItemStatusChangeListener',
        'InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract' => 'InetStudio\ChecksContest\Checks\Models\CheckModel',
        'InetStudio\ChecksContest\Checks\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\ChecksContest\Checks\Services\Back\DataTableService',
        'InetStudio\ChecksContest\Checks\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\ChecksContest\Checks\Services\Back\ItemsService',
        'InetStudio\ChecksContest\Checks\Contracts\Services\Back\ModerateServiceContract' => 'InetStudio\ChecksContest\Checks\Services\Back\ModerateService',
        'InetStudio\ChecksContest\Checks\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\ChecksContest\Checks\Services\Front\ItemsService',
        'InetStudio\ChecksContest\Checks\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\ChecksContest\Checks\Transformers\Back\Resource\IndexTransformer',
        'InetStudio\ChecksContest\Checks\Contracts\Transformers\Front\SearchItemTransformerContract' => 'InetStudio\ChecksContest\Checks\Transformers\Front\SearchItemTransformer',
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
