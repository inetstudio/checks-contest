<?php

namespace InetStudio\ChecksContest\Statuses\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Trait Status.
 */
trait Status
{
    /**
     * Отношение "один к одному" с моделью статуса.
     *
     * @return HasOne
     *
     * @throws BindingResolutionException
     */
    public function status(): HasOne
    {
        $statusModel = app()->make('InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract');

        return $this->hasOne(
            get_class($statusModel),
            'id',
            'status_id'
        );
    }
}
