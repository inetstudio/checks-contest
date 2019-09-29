<?php

namespace InetStudio\ChecksContest\Checks\Contracts\Services\Front;

use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends BaseServiceContract
{
    /**
     * Отправлен чек для участия в конкурсе.
     *
     * @param  array  $data
     *
     * @return CheckModelContract
     */
    public function send(array $data): CheckModelContract;

    /**
     * Получаем этапы конкурса с победителями.
     *
     * @return array
     */
    public function getContestStages(): array;

    /**
     * Поиск чеков.
     *
     * @param  string  $field
     * @param  string  $search
     * @param  string  $type
     *
     * @return Collection
     */
    public function search(string $field, string $search, string $type): Collection;
}
