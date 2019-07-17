<?php

namespace InetStudio\ChecksContest\Checks\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class RemoveDuplicatesCommand.
 */
class RemoveDuplicatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inetstudio:checks-contest:checks:remove-duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove duplicate receipts';

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
        $checksService = app()->make('InetStudio\ChecksContest\Checks\Contracts\Services\Back\ItemsServiceContract');
        $statusesService = app()->make('InetStudio\ChecksContest\Statuses\Contracts\Services\Back\ItemsServiceContract');

        $checks = $checksService->getModel()->get();
        $rejectedStatus = $statusesService->getModel()->where('alias', 'rejected')->first();

        $bar = $this->output->createProgressBar(count($checks));

        $codes = [];

        foreach ($checks as $check) {
            $receiptCodes = $check->getJSONData('additional_info', 'codes', []);

            if (empty($receiptCodes) || $check->status_id == $rejectedStatus->id) {
                continue;
            }

            foreach ($receiptCodes as $receiptCode) {
                if (($receiptCode[0] ?? '') == 'QR_CODE') {
                    $codeValue = trim($receiptCode[1] ?? '');

                    if (! $codeValue) {
                        continue;
                    }

                    if (! $check->hasJSONData('additional_info', 'duplicate')) {
                        if (isset($codes[$codeValue])) {
                            $check->status_id = $rejectedStatus->id;
                            $check->setJSONData('additional_info', 'duplicate', true);
                        } else {
                            $codes[$codeValue] = $check->id;
                            $check->setJSONData('additional_info', 'duplicate', false);
                        }

                        $check->save();
                    } else {
                        $codes[$codeValue] = $check->id;
                    }
                }
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
