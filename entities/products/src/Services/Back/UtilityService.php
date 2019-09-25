<?php

namespace InetStudio\ChecksContest\Products\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract;
use InetStudio\ChecksContest\Products\Contracts\Services\Back\UtilityServiceContract;

/**
 * Class UtilityService.
 */
class UtilityService extends BaseService implements UtilityServiceContract
{
    /**
     * UtilityService constructor.
     *
     * @param  ProductModelContract  $model
     */
    public function __construct(ProductModelContract $model)
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
