<?php

namespace InetStudio\ReceiptsContest\Prizes\Contracts\Services\Back;

use Illuminate\Support\Collection;

/**
 * Interface UtilityServiceContract.
 */
interface UtilityServiceContract
{
    /**
     * Получаем подсказки.
     *
     * @param  string  $search
     *
     * @return Collection
     */
    public function getSuggestions(string $search): Collection;
}
