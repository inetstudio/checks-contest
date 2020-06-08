<?php

namespace InetStudio\ReceiptsContest\Products\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    public array $bindings = [
        'InetStudio\ReceiptsContest\Products\Contracts\DTO\Back\Items\Attach\ItemsCollectionContract' => 'InetStudio\ReceiptsContest\Products\DTO\Back\Items\Attach\ItemsCollection',
        'InetStudio\ReceiptsContest\Products\Contracts\DTO\Back\Items\Attach\ItemDataContract' => 'InetStudio\ReceiptsContest\Products\DTO\Back\Items\Attach\ItemData',

        'InetStudio\ReceiptsContest\Products\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\ReceiptsContest\Products\Events\Back\ModifyItemEvent',

        'InetStudio\ReceiptsContest\Products\Contracts\Http\Resources\Back\Resource\Show\ItemResourceContract' => 'InetStudio\ReceiptsContest\Products\Http\Resources\Back\Resource\Show\ItemResource',
        'InetStudio\ReceiptsContest\Products\Contracts\Http\Resources\Back\Resource\Show\ItemsCollectionContract' => 'InetStudio\ReceiptsContest\Products\Http\Resources\Back\Resource\Show\ItemsCollection',

        'InetStudio\ReceiptsContest\Products\Contracts\Models\ProductModelContract' => 'InetStudio\ReceiptsContest\Products\Models\ProductModel',

        'InetStudio\ReceiptsContest\Products\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\ReceiptsContest\Products\Services\Back\ItemsService',
    ];

    public function provides()
    {
        return array_keys($this->bindings);
    }
}
