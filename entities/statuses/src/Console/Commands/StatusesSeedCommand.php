<?php

namespace InetStudio\ChecksContest\Statuses\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class StatusesSeedCommand.
 */
class StatusesSeedCommand extends Command
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:checks-contest:statuses:seed';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Seed social contest statuses';

    /**
     * Запуск команды.
     *
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        $classifiersGroupsService = app()->make(
            'InetStudio\Classifiers\Groups\Contracts\Services\Back\ItemsServiceContract'
        );

        $classifiersEntriesService = app()->make(
            'InetStudio\Classifiers\Entries\Contracts\Services\Back\ItemsServiceContract'
        );

        $statusesService = app()->make(
            'InetStudio\ChecksContest\Statuses\Contracts\Services\Back\ItemsServiceContract'
        );

        $statuses = [
            [
                'name' => 'Модерация',
                'alias' => 'moderation',
                'description' => 'Чеки, ожидающие модерацию',
                'color_class' => 'warning',
                'types' => [
                    'checks_contest_status_default' => 'Статус по умолчанию',
                    'checks_contest_status_check' => 'Проверка',
                ],
            ],
            [
                'name' => 'Одобрено',
                'alias' => 'approved',
                'description' => 'Одобренные чеки',
                'color_class' => 'primary',
                'types' => [
                    'checks_contest_status_main' => 'Основной статус',
                ],
            ],
            [
                'name' => 'Отклонено',
                'alias' => 'rejected',
                'description' => 'Отклоненные чеки',
                'color_class' => 'danger',
            ],
        ];

        $group = $classifiersGroupsService->getModel()::updateOrCreate(
            [
                'name' => 'Тип статуса конкурсного чека',
            ],
            [
                'alias' => 'checks_contest_status_type',
            ]
        );

        $entriesIDs = [];

        foreach ($statuses as $status) {
            $data = Arr::except($status, ['types']);

            $statusObj = $statusesService->getModel()::updateOrCreate($data);

            $classifiers = [];
            foreach ($status['types'] ?? [] as $alias => $value) {
                $entry = $classifiersEntriesService->getModel()::updateOrCreate(
                    [
                        'alias' => $alias,
                    ],
                    [
                        'value' => $value,
                    ]
                );

                $classifiers[] = $entry['id'];
                $entriesIDs[] = $entry['id'];
            }

            $statusObj->syncClassifiers($classifiers);
        }

        $currentEntriesIDs = $group->entries()
            ->pluck('classifiers_entries.id')
            ->toArray();

        $entriesIDs = array_unique(array_merge($entriesIDs, $currentEntriesIDs));
        $group->entries()->sync($entriesIDs);

        $this->info('Statuses seeding complete.');
    }
}
