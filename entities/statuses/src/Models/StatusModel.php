<?php

namespace InetStudio\ChecksContest\Statuses\Models;

use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InetStudio\Classifiers\Models\Traits\HasClassifiers;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract;

/**
 * Class StatusModel.
 */
class StatusModel extends Model implements StatusModelContract
{
    use Auditable;
    use SoftDeletes;
    use HasClassifiers;
    use BuildQueryScopeTrait;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'checks_contest_status';

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
    protected $table = 'checks_contest_statuses';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'description',
        'color_class',
        'fill_reason',
        'draw',
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
     * Настройка полей для поиска.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $arr = Arr::only($this->toArray(), ['id', 'name', 'alias', 'description']);

        return $arr;
    }

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
            'color_class',
            'fill_reason',
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
     * Сеттер атрибута description.
     *
     * @param $value
     */
    public function setDescriptionAttribute($value): void
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['description'] = trim(str_replace('&nbsp;', ' ', strip_tags($value)));
    }

    /**
     * Сеттер атрибута color_class.
     *
     * @param $value
     */
    public function setColorClassAttribute($value): void
    {
        $this->attributes['color_class'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута fill_reason.
     *
     * @param $value
     */
    public function setFillReasonAttribute($value): void
    {
        $value = $value[0] ?? (is_array($value) ? '' : $value);

        $this->attributes['fill_reason'] = (bool) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута draw.
     *
     * @param $value
     */
    public function setDrawAttribute($value): void
    {
        $value = $value[0] ?? (is_array($value) ? '' : $value);

        $this->attributes['draw'] = (bool) trim(strip_tags($value));
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
     * Отношение "один ко многим" с моделью чеков.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function checks(): HasMany
    {
        $checkModel = app()->make('InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract');

        return $this->hasMany(
            get_class($checkModel),
            'status_id',
            'id'
        );
    }
}
