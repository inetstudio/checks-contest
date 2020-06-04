<?php

namespace InetStudio\ReceiptsContest\Prizes\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'InetStudio\ReceiptsContest\Prizes\Contracts\Models\PrizeModelContract' => \InetStudio\ReceiptsContest\Prizes\Policies\PrizeModelPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
