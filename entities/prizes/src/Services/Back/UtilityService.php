<?php

namespace InetStudio\ChecksContest\Prizes\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ChecksContest\Prizes\Contracts\Services\Back\UtilityServiceContract;

/**
 * Class UtilityService.
 */
class UtilityService extends BaseService implements UtilityServiceContract
{
    /**
     * UtilityService constructor.
     *
     * @param  PrizeModelContract  $model
     */
    public function __construct(PrizeModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Получаем подсказки.
     *
     * @param  string  $search
     *
     * @return Collection
     */
    public function getSuggestions(string $search): Collection
    {
        $items = $this->model::where(
            [
                ['name', 'LIKE', '%'.$search.'%'],
            ]
        )->get();

        return $items;
    }
}
