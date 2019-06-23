<?php

namespace InetStudio\ChecksContest\Prizes\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class PrizeModel.
 */
class PrizeModel extends Model implements PrizeModelContract
{
    use Auditable;
    use SoftDeletes;
    use BuildQueryScopeTrait;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'checks_contest_prize';

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
    protected $table = 'checks_contest_prizes';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
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
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'name',
            'alias',
        ];
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
     * Сеттер атрибута alias.
     *
     * @param $value
     */
    public function setAliasAttribute($value): void
    {
        $this->attributes['alias'] = trim(strip_tags($value));
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
     * Связь с моделью чека.
     *
     * @return BelongsToMany
     *
     * @throws BindingResolutionException
     */
    public function checks(): BelongsToMany
    {
        $checkModel = app()->make('InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract');

        return $this->belongsToMany(
            get_class($checkModel),
            'checks_contest_checks_prizes',
            'prize_id',
            'check_id'
        )
            ->withPivot(['confirmed', 'date_start', 'date_end'])
            ->withTimestamps();
    }
}
