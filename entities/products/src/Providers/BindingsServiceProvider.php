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
        'InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract' => 'InetStudio\ChecksContest\Products\Models\ProductModel',
        'InetStudio\ChecksContest\Products\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\ChecksContest\Products\Services\Back\ItemsService',
        'InetStudio\ChecksContest\Products\Contracts\Transformers\Back\Resource\ShowTransformerContract' => 'InetStudio\ChecksContest\Products\Transformers\Back\Resource\ShowTransformer',
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
