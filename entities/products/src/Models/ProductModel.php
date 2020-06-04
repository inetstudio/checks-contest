<?php

namespace InetStudio\ReceiptsContest\Products\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InetStudio\AdminPanel\Models\Traits\HasJSONColumns;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\ReceiptsContest\Products\Contracts\Models\ProductModelContract;

class ProductModel extends Model implements ProductModelContract
{
    use Auditable;
    use SoftDeletes;
    use HasJSONColumns;
    use BuildQueryScopeTrait;

    const ENTITY_TYPE = 'receipts_contest_product';

    protected bool $auditTimestamps = true;

    protected $table = 'receipts_contest_products';

    protected $fillable = [
        'fns_receipt_id',
        'receipt_id',
        'name',
        'quantity',
        'price',
        'product_data',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'product_data' => 'array',
    ];

    public function getSumAttribute(): float
    {
        return (float) number_format($this->getAttribute('quantity') * ($this->getAttribute('price') / 100), 2, '.', '');
    }

    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    public function fnsReceipt(): BelongsTo
    {
        $fnsReceiptModel = app()->make('InetStudio\Fns\Receipts\Contracts\Models\ReceiptModelContract');

        return $this->belongsTo(
            get_class($fnsReceiptModel),
            'id',
            'fns_receipt_id'
        );
    }

    public function receipt(): BelongsTo
    {
        $receiptModel = app()->make('InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract');

        return $this->belongsTo(
            get_class($receiptModel),
            'id',
            'receipt_id'
        );
    }
}
