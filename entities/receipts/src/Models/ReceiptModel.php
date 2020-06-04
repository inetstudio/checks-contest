<?php

namespace InetStudio\ReceiptsContest\Receipts\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use InetStudio\ACL\Users\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InetStudio\AdminPanel\Models\Traits\HasJSONColumns;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InetStudio\ReceiptsContest\Statuses\Models\Traits\HasStatus;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;

class ReceiptModel extends Model implements ReceiptModelContract
{
    use Auditable;
    use HasImages;
    use SoftDeletes;
    use HasJSONColumns;

    const ENTITY_TYPE = 'receipts_contest_receipt';

    protected bool $auditTimestamps = true;

    protected array $images = [
        'config' => 'receipts_contest_receipts',
        'model' => 'receipt',
    ];

    protected $table = 'receipts_contest_receipts';

    protected $fillable = [
        'fns_receipt_id',
        'verify_hash',
        'receipt_data',
        'additional_info',
        'user_id',
        'status_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'receipt_data' => 'array',
        'additional_info' => 'array',
    ];

    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    public function scopeWin($query)
    {
        return $query->whereHas('prizes', function ($prizesQuery) {
            $prizesQuery->where('receipts_contest_receipts_prizes.confirmed', 1);
        });
    }

    use HasStatus;
    use HasUser;

    public function prizes(): BelongsToMany
    {
        $prizeModel = app()->make('InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract');

        return $this->belongsToMany(
                get_class($prizeModel),
                'receipts_contest_receipts_prizes',
                'receipt_id',
                'prize_id'
            )
            ->withPivot(['confirmed', 'date_start', 'date_end'])
            ->withTimestamps();
    }

    public function products(): HasMany
    {
        $productModel = app()->make('InetStudio\ReceiptsContest\Products\Contracts\Models\ProductModelContract');

        return $this->hasMany(
            get_class($productModel),
            'receipt_id',
            'id'
        );
    }

    public function fnsReceipt(): HasOne
    {
        $fnsReceiptModel = app()->make('InetStudio\Fns\Receipts\Contracts\Models\ReceiptModelContract');

        return $this->hasOne(
            get_class($fnsReceiptModel),
            'id',
            'fns_receipt_id'
        );
    }
}
