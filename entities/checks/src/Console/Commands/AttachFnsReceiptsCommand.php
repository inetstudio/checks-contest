<?php

namespace InetStudio\ChecksContest\Checks\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Console\Commands\AttachFnsReceiptsCommandContract;

/**
 * Class AttachFnsReceiptsCommand.
 */
class AttachFnsReceiptsCommand extends Command implements AttachFnsReceiptsCommandContract
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inetstudio:checks-contest:checks:fns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attach FNS receipts to contest checks';

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
        $receiptsService = app()->make('InetStudio\Fns\Receipts\Contracts\Services\Back\ItemsServiceContract');

        $status = $statusesService->getDefaultStatus();

        $checks = $checksService->getModel()->where([
            ['status_id', '=', $status->id],
        ])->doesntHave('receipts')->get();

        $bar = $this->output->createProgressBar(count($checks));

        foreach ($checks as $check) {
            $codes = $check->getJSONData('additional_info', 'codes', []);

            $receiptsIds = [];
            foreach ($codes as $code) {
                if (! (($code[0] ?? '') == 'QR_CODE')) {
                    continue;
                }

                if (! ($code[1] ?? '')) {
                    continue;
                }

                $receipt = $receiptsService->getReceiptByQrCode($code[1]);

                if ($receipt) {
                    $receiptsIds[] = $receipt['id'];
                }
            }

            if (! empty($receiptsIds)) {
                $check->receipts()->sync($receiptsIds);
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
