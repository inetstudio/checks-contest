<?php

namespace InetStudio\ReceiptsContest\Prizes\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract;

class PrizeModel extends Model implements PrizeModelContract
{
    use Auditable;
    use SoftDeletes;

    const ENTITY_TYPE = 'receipts_contest_prize';

    protected bool $auditTimestamps = true;

    protected $table = 'receipts_contest_prizes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    public function receipts(): BelongsToMany
    {
        $receiptModel = resolve('InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract');

        return $this->belongsToMany(
                get_class($receiptModel),
                'receipts_contest_receipts_prizes',
                'prize_id',
                'receipt_id'
            )
            ->withPivot(['confirmed', 'date_start', 'date_end'])
            ->withTimestamps();
    }
}
