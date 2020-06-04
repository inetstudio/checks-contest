<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Http\Resources\Back\Resource\Index;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Routing\UrlRoutable;

interface ItemResourceContract extends ArrayAccess, JsonSerializable, Responsable, UrlRoutable
{
}
