<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/receipts-contest',
    ],
    function () {
        Route::any('statuses/data', 'DataControllerContract@getIndexData')
            ->name('back.receipts-contest.statuses.data.index');

        Route::post('statuses/suggestions', 'UtilityControllerContract@getSuggestions')
            ->name('back.receipts-contest.statuses.utility.suggestions');

        Route::resource(
            'statuses',
            'ResourceControllerContract',
            [
                'as' => 'back.receipts-contest',
            ]
        );
    }
);
