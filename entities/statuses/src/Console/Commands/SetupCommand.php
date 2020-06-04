<?php

namespace InetStudio\ReceiptsContest\Statuses\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

class SetupCommand extends BaseSetupCommand
{
    protected $name = 'inetstudio:receipts-contest:statuses:setup';

    protected $description = 'Setup receipts contest statuses package';

    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Publish migrations',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\ReceiptsContest\Statuses\Providers\ServiceProvider',
                    '--tag' => 'migrations',
                ],
            ],
            [
                'type' => 'artisan',
                'description' => 'Migration',
                'command' => 'migrate',
            ],
            [
                'type' => 'artisan',
                'description' => 'Seed statuses',
                'command' => 'inetstudio:receipts-contest:statuses:seed',
            ],
        ];
    }
}
