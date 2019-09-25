<?php

namespace InetStudio\ChecksContest\Products\Console\Commands;

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
    protected $name = 'inetstudio:checks-contest:products:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup checks contest products package';

    /**
     * Инициализация команд.
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Publish migrations',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\ChecksContest\Products\Providers\ServiceProvider',
                    '--tag' => 'migrations',
                ],
            ],
            [
                'type' => 'artisan',
                'description' => 'Migration',
                'command' => 'migrate',
            ],
        ];
    }
}
