<?php

namespace InetStudio\ChecksContest\Checks\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InetStudio\AdminPanel\Models\Traits\HasJSONColumns;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InetStudio\ChecksContest\Statuses\Models\Traits\Status;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class CheckModel.
 */
class CheckModel extends Model implements CheckModelContract
{
    use Auditable;
    use HasImages;
    use SoftDeletes;
    use HasJSONColumns;
    use BuildQueryScopeTrait;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'checks_contest_check';

    /**
     * Should the timestamps be audited?
     *
     * @var bool
     */
    protected $auditTimestamps = true;

    /**
     * Настройки для генерации изображений.
     *
     * @var array
     */
    protected $images = [
        'config' => 'checks_contest_checks',
        'model' => 'check',
    ];

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'checks_contest_checks';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'verify_hash',
        'receipt_data',
        'additional_info',
        'status_id',
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
        'receipt_data' => 'array',
        'additional_info' => 'array',
    ];

    /**
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id', 'receipt_data', 'additional_info', 'status_id',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'media' => function ($mediaQuery) {
                $mediaQuery->select(['id', 'model_id', 'model_type', 'collection_name', 'file_name', 'disk']);
            },

            'status' => function ($statusQuery) {
                $statusQuery->select(['id', 'name', 'alias', 'color_class']);
            },

            'prizes' => function ($prizeQuery) {
                $prizeQuery->select(['id', 'name', 'alias']);
            },

            'products' => function ($prizeQuery) {
                $prizeQuery->select(['id', 'name', 'quantity', 'price']);
            },

            'fnsReceipts' => function ($receiptQuery) {
                $receiptQuery->select(['id', 'qr_code', 'receipt']);
            },
        ];
    }

    /**
     * Сеттер атрибута verify_hash.
     *
     * @param $value
     */
    public function setVerifyHashAttribute($value)
    {
        $this->attributes['verify_hash'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута receipt_data.
     *
     * @param $value
     */
    public function setReceiptDataAttribute($value)
    {
        $this->attributes['receipt_data'] = json_encode((array) $value);
    }

    /**
     * Сеттер атрибута additional_info.
     *
     * @param $value
     */
    public function setAdditionalInfoAttribute($value)
    {
        $this->attributes['additional_info'] = json_encode((array) $value);
    }

    /**
     * Сеттер атрибута status_id.
     *
     * @param $value
     */
    public function setStatusIdAttribute($value)
    {
        $this->attributes['status_id'] = (! $value) ? 1 : (int) $value;
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
     * Заготовка запроса "Победные чеки".
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeWin($query)
    {
        return $query->whereHas('prizes', function ($prizesQuery) {
            $prizesQuery->where('checks_contest_checks_prizes.confirmed', 1);
        });
    }

    use Status;

    /**
     * Связь с моделью приза.
     *
     * @return BelongsToMany
     *
     * @throws BindingResolutionException
     */
    public function prizes(): BelongsToMany
    {
        $prizeModel = app()->make('InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract');

        return $this->belongsToMany(
                get_class($prizeModel),
                'checks_contest_checks_prizes',
                'check_id',
                'prize_id'
            )
            ->withPivot(['confirmed', 'date_start', 'date_end'])
            ->withTimestamps();
    }

    /**
     * Связь с моделью продукта.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function products(): HasMany
    {
        $productModel = app()->make('InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract');

        return $this->hasMany(
            get_class($productModel),
            'check_id',
            'id'
        );
    }

    /**
     * Связь с моделью чека ФНС.
     *
     * @return BelongsToMany
     *
     * @throws BindingResolutionException
     */
    public function fnsReceipts(): BelongsToMany
    {
        $receiptModel = app()->make('InetStudio\Fns\Receipts\Contracts\Models\ReceiptModelContract');

        return $this->belongsToMany(
                get_class($receiptModel),
                'checks_contest_checks_fns_receipts',
                'check_id',
                'receipt_id'
            )
            ->withTimestamps();
    }
}
