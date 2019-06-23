<?php

namespace InetStudio\ChecksContest\Checks\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class CreateFoldersCommand.
 */
class CreateFoldersCommand extends Command
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:checks-contest:checks:folders';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Create checks contest checks folders';

    /**
     * Запуск команды.
     */
    public function handle(): void
    {
        $folders = [
            'checks_contest_checks',
        ];

        foreach ($folders as $folder) {
            if (config('filesystems.disks.'.$folder)) {
                $path = config('filesystems.disks.'.$folder.'.root');
                $this->createDir($path);
            }
        }
    }

    /**
     * Создание директории.
     *
     * @param $path
     */
    private function createDir($path): void
    {
        if (is_dir($path)) {
            $this->info($path.' Already created.');

            return;
        }

        mkdir($path, 0777, true);
        $this->info($path.' Has been created.');
    }
}
