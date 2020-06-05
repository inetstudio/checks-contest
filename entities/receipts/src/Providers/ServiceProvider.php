<?php

namespace InetStudio\ReceiptsContest\Receipts\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
    }

    protected function registerConsoleCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands(
            [
                'InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\AttachFnsReceiptsCommandContract',
                'InetStudio\ReceiptsContest\Receipts\Console\Commands\AttachProductsCommand',
                'InetStudio\ReceiptsContest\Receipts\Console\Commands\CreateFoldersCommand',
                'InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\ModerateCommandContract',
                'InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\RecognizeCodesCommandContract',
                'InetStudio\ReceiptsContest\Receipts\Console\Commands\SetupCommand',
                'InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\SetWinnerCommandContract',
            ]
        );
    }

    protected function registerPublishes(): void
    {
        $this->publishes(
            [
                __DIR__.'/../../config/receipts_contest_receipts.php' => config_path('receipts_contest_receipts.php'),
            ],
            'config'
        );

        $this->mergeConfigFrom(__DIR__.'/../../config/services.php', 'services');

        $this->mergeConfigFrom(__DIR__.'/../../config/filesystems.php', 'filesystems.disks');

        if (! $this->app->runningInConsole()) {
            return;
        }

        if (Schema::hasTable('receipts_contest_receipts')) {
            return;
        }

        $timestamp = date('Y_m_d_His', time());
        $this->publishes(
            [
                __DIR__.'/../../database/migrations/create_receipts_contest_receipts_tables.php.stub' => database_path(
                    'migrations/'.$timestamp.'_create_receipts_contest_receipts_tables.php'
                ),
            ],
            'migrations'
        );
    }

    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.receipts-contest.receipts');
    }
}
