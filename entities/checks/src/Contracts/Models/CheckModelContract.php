<?php

namespace InetStudio\ChecksContest\Checks\Contracts\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use InetStudio\AdminPanel\Base\Contracts\Models\BaseModelContract;

/**
 * Interface CheckModelContract.
 */
interface CheckModelContract extends BaseModelContract, Auditable, HasMedia
{
}
