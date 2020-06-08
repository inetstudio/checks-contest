<?php

namespace InetStudio\ReceiptsContest\Prizes\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPrizes
{
    public function prizes(): BelongsToMany
    {
        $prizeModel = resolve('InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract');

        return $this->belongsToMany(
                get_class($prizeModel),
                'receipts_contest_receipts_prizes',
                'receipt_id',
                'prize_id'
            )
            ->withPivot(['confirmed', 'date_start', 'date_end'])
            ->withTimestamps();
    }
}
