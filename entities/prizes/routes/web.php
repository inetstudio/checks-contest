<?php

Route::group(
    [
        'namespace' => 'InetStudio\ChecksContest\Prizes\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/checks-contest',
    ],
    function () {
        Route::any('prizes/data', 'DataControllerContract@data')
            ->name('back.checks-contest.prizes.data.index');

        Route::post('prizes/suggestions', 'UtilityControllerContract@getSuggestions')
            ->name('back.checks-contest.prizes.getSuggestions');

        Route::resource(
            'prizes',
            'ResourceControllerContract',
            [
                'except' => [
                    'show',
                ],
                'as' => 'back.checks-contest',
            ]
        );
    }
);
