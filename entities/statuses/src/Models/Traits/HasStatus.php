<?php

namespace InetStudio\ReceiptsContest\Statuses\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasStatus
{
    public function status(): HasOne
    {
        $statusModel = resolve('InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract');

        return $this->hasOne(
            get_class($statusModel),
            'id',
            'status_id'
        );
    }
}
