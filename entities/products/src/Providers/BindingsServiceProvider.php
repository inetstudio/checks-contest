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
