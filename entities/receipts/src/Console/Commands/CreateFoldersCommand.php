<?php

namespace InetStudio\ReceiptsContest\Receipts\Console\Commands;

use Illuminate\Console\Command;

class CreateFoldersCommand extends Command
{
    protected $name = 'inetstudio:receipts-contest:receipts:folders';

    protected $description = 'Create receipts contest receipts folders';

    public function handle(): void
    {
        $folders = [
            'receipts_contest_receipts',
        ];

        foreach ($folders as $folder) {
            if (config('filesystems.disks.'.$folder)) {
                $path = config('filesystems.disks.'.$folder.'.root');
                $this->createDir($path);
            }
        }
    }

    protected function createDir($path): void
    {
        if (is_dir($path)) {
            $this->info($path.' Already created.');

            return;
        }

        mkdir($path, 0777, true);
        $this->info($path.' Has been created.');
    }
}
