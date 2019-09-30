<?php

Route::group(
    [
        'namespace' => 'InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/checks-contest',
    ],
    function () {
        Route::any('checks/data', 'DataControllerContract@data')
            ->name('back.checks-contest.checks.data.index');

        Route::post('checks/moderate/{id}/{statusAlias}', 'ModerateControllerContract@moderate')
            ->name('back.checks-contest.checks.moderate');

        Route::get('checks/export', 'ExportControllerContract@exportItems')
            ->name('back.checks-contest.checks.export');

        Route::get('checks/full/export', 'ExportControllerContract@exportFullItems')
            ->name('back.checks-contest.checks.full.export');

        Route::resource(
            'checks',
            'ResourceControllerContract',
            [
                'except' => [
                    'create',
                    'store',
                ],
                'as' => 'back.checks-contest',
            ]
        );
    }
);

Route::group(
    [
        'namespace' => 'InetStudio\ChecksContest\Checks\Contracts\Http\Controllers\Front',
        'middleware' => ['web'],
    ],
    function () {
        Route::post('checks-contest/checks/send', 'ItemsControllerContract@send')
            ->name('front.checks-contest.checks.send');

        Route::post('checks-contest/checks/search/{field}/{type}', 'ItemsControllerContract@search')
            ->where('field', 'phone|email')
            ->where('type', 'winner|status')
            ->name('front.checks-contest.checks.search');
    }
);
