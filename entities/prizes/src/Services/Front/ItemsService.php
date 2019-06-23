<?php

namespace InetStudio\ChecksContest\Prizes\Services\Front;

use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\ChecksContest\Prizes\Contracts\Models\PrizeModelContract;
use InetStudio\ChecksContest\Prizes\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  PrizeModelContract  $model
     */
    public function __construct(PrizeModelContract $model)
    {
        parent::__construct($model);
    }
}
