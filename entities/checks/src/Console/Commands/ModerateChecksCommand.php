<?php

namespace InetStudio\ChecksContest\Checks\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Console\Commands\ModerateChecksCommandContract;

/**
 * Class ModerateChecksCommand.
 */
class ModerateChecksCommand extends Command implements ModerateChecksCommandContract
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inetstudio:checks-contest:checks:moderate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Moderate checks';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Запуск команды.
     *
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $items = $this->getChecks();
        $this->moderate($items);
    }

    /**
     * Получаем чеки для модерации.
     *
     * @return Collection
     *
     * @throws BindingResolutionException
     */
    protected function getChecks(): Collection
    {
        $checksService = app()->make('InetStudio\ChecksContest\Checks\Contracts\Services\Front\ItemsServiceContract');
        $statusesService = app()->make('InetStudio\ChecksContest\Statuses\Contracts\Services\Back\ItemsServiceContract');

        $status = $statusesService->getDefaultStatus();

        if (! $status) {
            return collect([]);
        }

        $items = $checksService->getModel()->where(
            [
                ['status_id', '=', $status->id],
            ]
        )->get();

        return $items;
    }

    /**
     * Модерируем чеки.
     *
     * @param  Collection  $items
     */
    protected function moderate(Collection $items): void
    {
    }
}
