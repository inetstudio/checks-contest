<?php

namespace InetStudio\ChecksContest\Checks\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Загрузка сервиса.
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
    }

    /**
     * Регистрация команд.
     */
    protected function registerConsoleCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands(
            [
                'InetStudio\ChecksContest\Checks\Contracts\Console\Commands\AttachFnsReceiptsCommandContract',
                'InetStudio\ChecksContest\Checks\Console\Commands\AttachProductsCommand',
                'InetStudio\ChecksContest\Checks\Console\Commands\CreateFoldersCommand',
                'InetStudio\ChecksContest\Checks\Contracts\Console\Commands\ModerateChecksCommandContract',
                'InetStudio\ChecksContest\Checks\Contracts\Console\Commands\RecognizeCodesCommandContract',
                'InetStudio\ChecksContest\Checks\Console\Commands\SetupCommand',
                'InetStudio\ChecksContest\Checks\Contracts\Console\Commands\SetWinnerCommandContract',
            ]
        );
    }

    /**
     * Регистрация ресурсов.
     */
    protected function registerPublishes(): void
    {
        $this->publishes(
            [
                __DIR__.'/../../config/checks_contest_checks.php' => config_path('checks_contest_checks.php'),
            ],
            'config'
        );

        $this->mergeConfigFrom(__DIR__.'/../../config/filesystems.php', 'filesystems.disks');

        if (! $this->app->runningInConsole()) {
            return;
        }

        if (Schema::hasTable('checks_contest_checks')) {
            return;
        }

        $timestamp = date('Y_m_d_His', time());
        $this->publishes(
            [
                __DIR__.'/../../database/migrations/create_checks_contest_checks_tables.php.stub' => database_path(
                    'migrations/'.$timestamp.'_create_checks_contest_checks_tables.php'
                ),
            ],
            'migrations'
        );
    }

    /**
     * Регистрация путей.
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Регистрация представлений.
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.checks-contest.checks');
    }
}
