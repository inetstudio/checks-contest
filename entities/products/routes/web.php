<?php

Route::group(
    [
        'namespace' => 'InetStudio\ChecksContest\Products\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/checks-contest',
    ],
    function () {
        Route::any('products/data', 'DataControllerContract@data')
            ->name('back.checks-contest.products.data.index');

        Route::post('products/suggestions', 'UtilityControllerContract@getSuggestions')
            ->name('back.checks-contest.products.getSuggestions');

        Route::resource(
            'products',
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
