<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\ReceiptsContest\Prizes\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/receipts-contest',
    ],
    function () {
        Route::any('prizes/data', 'DataControllerContract@getIndexData')
            ->name('back.receipts-contest.prizes.data.index');

        Route::post('prizes/suggestions', 'UtilityControllerContract@getSuggestions')
            ->name('back.receipts-contest.prizes.utility.suggestions');

        Route::resource(
            'prizes',
            'ResourceControllerContract',
            [
                'as' => 'back.receipts-contest',
            ]
        );
    }
);
