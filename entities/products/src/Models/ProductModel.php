<?php

namespace InetStudio\ChecksContest\Products\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InetStudio\AdminPanel\Models\Traits\HasJSONColumns;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract;

/**
 * Class ProductModel.
 */
class ProductModel extends Model implements ProductModelContract
{
    use Auditable;
    use SoftDeletes;
    use HasJSONColumns;
    use BuildQueryScopeTrait;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'checks_contest_product';

    /**
     * Should the timestamps be audited?
     *
     * @var bool
     */
    protected $auditTimestamps = true;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'checks_contest_products';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'fns_receipt_id',
        'receipt_id',
        'name',
        'quantity',
        'price',
        'product_data',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы к базовым типам.
     *
     * @var array
     */
    protected $casts = [
        'product_data' => 'array',
    ];

    /**
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'fns_receipt_id',
            'receipt_id',
            'name',
            'quantity',
            'price',
            'product_data',
        ];
    }

    /**
     * Сеттер атрибута fns_receipt_id.
     *
     * @param $value
     */
    public function setFnsReceiptIdAttribute($value): void
    {
        $this->attributes['fns_receipt_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута check_id.
     *
     * @param $value
     */
    public function setReceiptIdAttribute($value): void
    {
        $this->attributes['receipt_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута name.
     *
     * @param $value
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута quantity.
     *
     * @param $value
     */
    public function setQuantityAttribute($value): void
    {
        $this->attributes['quantity'] = $value;
    }

    /**
     * Сеттер атрибута price.
     *
     * @param $value
     */
    public function setPriceAttribute($value): void
    {
        $this->attributes['price'] = (int) $value;
    }

    /**
     * Сеттер атрибута product_data.
     *
     * @param $value
     */
    public function setProductDataAttribute($value)
    {
        $this->attributes['product_data'] = json_encode((array) $value);
    }

    /**
     * Геттер атрибута price_formatted.
     *
     * @return float
     */
    public function getPriceFormattedAttribute(): float
    {
        return (float) number_format($this->getAttribute('price') / 100, 2, '.', '');
    }

    /**
     * Геттер атрибута sum.
     *
     * @return float
     */
    public function getSumAttribute(): float
    {
        return (float) number_format($this->getAttribute('quantity') * ($this->getAttribute('price') / 100), 2, '.', '');
    }

    /**
     * Геттер атрибута type.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    /**
     * Связь с моделью чека ФНС.
     *
     * @return BelongsTo
     *
     * @throws BindingResolutionException
     */
    public function fnsReceipt(): BelongsTo
    {
        $fnsReceiptModel = app()->make('InetStudio\Fns\Receipts\Contracts\Models\ReceiptModelContract');

        return $this->belongsTo(
            get_class($fnsReceiptModel),
            'id',
            'fns_receipt_id'
        );
    }

    /**
     * Связь с моделью чека.
     *
     * @return BelongsTo
     *
     * @throws BindingResolutionException
     */
    public function receipt(): BelongsTo
    {
        $checkModel = app()->make('InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract');

        return $this->belongsTo(
            get_class($checkModel),
            'id',
            'receipt_id'
        );
    }
}
