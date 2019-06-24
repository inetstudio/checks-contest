<?php

namespace InetStudio\ChecksContest\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

/**
 * Class SetupCommand.
 */
class SetupCommand extends BaseSetupCommand
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:checks-contest:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup checks package';

    /**
     * Инициализация команд.
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Classifiers setup',
                'command' => 'inetstudio:classifiers:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Fns setup',
                'command' => 'inetstudio:fns:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Checks contest checks setup',
                'command' => 'inetstudio:checks-contest:checks:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Checks contest prizes setup',
                'command' => 'inetstudio:checks-contest:prizes:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Checks contest statuses setup',
                'command' => 'inetstudio:checks-contest:statuses:setup',
            ],
        ];
    }
}
