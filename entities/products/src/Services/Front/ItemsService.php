<?php

namespace InetStudio\ChecksContest\Products\Services\Front;

use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\ChecksContest\Products\Contracts\Models\ProductModelContract;
use InetStudio\ChecksContest\Products\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  ProductModelContract  $model
     */
    public function __construct(ProductModelContract $model)
    {
        parent::__construct($model);
    }
}
