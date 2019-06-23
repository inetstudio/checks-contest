<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\ChecksContest\Statuses\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/checks-contest',
    ],
    function () {
        Route::any('checks-contest/statuses/data', 'DataControllerContract@data')
            ->name('back.checks-contest.statuses.data.index');

        Route::post('checks-contest/statuses/suggestions', 'UtilityControllerContract@getSuggestions')
            ->name('back.checks-contest.statuses.getSuggestions');

        Route::resource(
            'statuses', 'ResourceControllerContract',
            [
                'except' => [
                    'show',
                ],
                'as' => 'back.checks-contest'
            ]
        );
    }
);
