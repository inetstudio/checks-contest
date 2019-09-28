<?php

namespace InetStudio\ChecksContest\Checks\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\ChecksContest\Checks\Contracts\Console\Commands\RecognizeCodesCommandContract;

/**
 * Class RecognizeCodesCommand.
 */
class RecognizeCodesCommand extends Command implements RecognizeCodesCommandContract
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inetstudio:checks-contest:checks:recognize-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recognize QR codes';

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

        $status = $statusesService->getDefaultStatus();

        $checks = $checksService->getModel()->where([
            ['status_id', '=', $status->id],
        ])->get();

        $bar = $this->output->createProgressBar(count($checks));

        foreach ($checks as $check) {
            if (! $check->hasJSONData('receipt_data', 'codes')) {
                $imagePath = $check->getFirstMediaPath('images');

                $codes = DecodeBarcodeFile($imagePath, 0x4000000);
                $codes = (is_array($codes)) ? $codes : [];

                $check->setJSONData('receipt_data', 'codes', $codes);
                $check->save();
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
