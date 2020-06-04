<?php

namespace InetStudio\ReceiptsContest\Console\Commands;

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
    protected $name = 'inetstudio:receipts-contest:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup receipts contest package';

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
                'description' => 'Receipts contest receipts setup',
                'command' => 'inetstudio:receipts-contest:receipts:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Receipts contest prizes setup',
                'command' => 'inetstudio:receipts-contest:prizes:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Receipts contest products setup',
                'command' => 'inetstudio:receipts-contest:products:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Receipts contest statuses setup',
                'command' => 'inetstudio:receipts-contest:statuses:setup',
            ],
        ];
    }
}
