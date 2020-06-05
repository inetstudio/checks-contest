<?php

namespace InetStudio\ReceiptsContest\Statuses\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract as StatusesServiceContract;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\ItemsServiceContract as ClassifiersGroupsServiceContract;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\ItemsServiceContract as ClassifiersEntriesServiceContract;

class StatusesSeedCommand extends Command
{
    protected $name = 'inetstudio:receipts-contest:statuses:seed';

    protected $description = 'Seed receipts contest statuses';

    protected array $statuses = [
        [
            'name' => 'Модерация',
            'alias' => 'moderation',
            'description' => 'Чеки, ожидающие модерацию',
            'color_class' => 'warning',
            'types' => [
                'receipts_contest_status_default' => 'Статус по умолчанию',
                'receipts_contest_status_check' => 'Проверка',
            ],
        ],
        [
            'name' => 'Предварительно одобрено',
            'alias' => 'preliminarily_approved',
            'description' => 'Предварительно одобренные чеки',
            'color_class' => 'default',
            'types' => [
                'receipts_contest_status_draw' => 'Участвует в розыгрыше призов',
            ],
        ],
        [
            'name' => 'Одобрено',
            'alias' => 'approved',
            'description' => 'Одобренные чеки',
            'color_class' => 'primary',
            'types' => [
                'receipts_contest_status_final' => 'Финальный статус',
                'receipts_contest_status_draw' => 'Участвует в розыгрыше призов',
            ],
        ],
        [
            'name' => 'Отклонено',
            'alias' => 'rejected',
            'description' => 'Отклоненные чеки',
            'color_class' => 'danger',
            'types' => [
                'receipts_contest_status_reason' => 'Необходимо указать причину',
            ],
        ],
    ];

    protected ClassifiersGroupsServiceContract $groupsService;

    protected ClassifiersEntriesServiceContract $entriesService;

    protected StatusesServiceContract $statusesService;

    public function __construct(
        ClassifiersGroupsServiceContract $groupsService,
        ClassifiersEntriesServiceContract $entriesService,
        StatusesServiceContract $statusesService
    ) {
        parent::__construct();

        $this->groupsService = $groupsService;
        $this->entriesService = $entriesService;
        $this->statusesService = $statusesService;
    }

    public function handle(): void
    {
        $group = $this->groupsService->getModel()::updateOrCreate(
            [
                'name' => 'Тип статуса конкурсного чека',
            ],
            [
                'alias' => 'receipts_contest_status_type',
            ]
        );

        $entriesIDs = [];

        foreach ($this->statuses as $status) {
            $data = Arr::except($status, ['types']);

            $statusObj = $this->statusesService->getModel()::updateOrCreate($data);

            $classifiers = [];
            foreach ($status['types'] ?? [] as $alias => $value) {
                $entry = $this->entriesService->getModel()::updateOrCreate(
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
