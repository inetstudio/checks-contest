<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Models;

use Spatie\MediaLibrary\HasMedia;
use OwenIt\Auditing\Contracts\Auditable;
use InetStudio\AdminPanel\Base\Contracts\Models\BaseModelContract;

interface ReceiptModelContract extends BaseModelContract, Auditable, HasMedia
{
}
