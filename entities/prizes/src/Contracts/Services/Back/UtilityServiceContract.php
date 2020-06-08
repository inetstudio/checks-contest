<?php

namespace InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back;

use Illuminate\Support\Collection;

interface UtilityServiceContract
{
    public function getSuggestions(string $search): Collection;
}
