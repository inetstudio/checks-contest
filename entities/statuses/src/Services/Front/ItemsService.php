<?php

namespace InetStudio\ChecksContest\Statuses\Services\Front;

use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ChecksContest\Statuses\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  StatusModelContract  $model
     */
    public function __construct(StatusModelContract $model)
    {
        parent::__construct($model);
    }
}
