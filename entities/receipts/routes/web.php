<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/receipts-contest',
    ],
    function () {
        Route::any('receipts/data', 'DataControllerContract@getIndexData')
            ->name('back.receipts-contest.receipts.data.index');

        Route::post('receipts/moderate/', 'ModerateControllerContract@moderate')
            ->name('back.receipts-contest.receipts.moderate');

        Route::get('receipts/export/default', 'ExportControllerContract@exportItems')
            ->name('back.receipts-contest.receipts.export.default');

        Route::get('receipts/export/full', 'ExportControllerContract@exportItemsFull')
            ->name('back.receipts-contest.receipts.export.full');

        Route::resource(
            'receipts',
            'ResourceControllerContract',
            [
                'except' => [
                    'create',
                    'edit',
                    'store',
                ],
                'as' => 'back.receipts-contest',
            ]
        );
    }
);

Route::group(
    [
        'namespace' => 'InetStudio\ReceiptsContest\Receipts\Contracts\Http\Controllers\Front',
        'middleware' => ['web'],
        'prefix' => 'receipts-contest',
    ],
    function () {
        Route::post('receipts/send', 'ItemsControllerContract@send')
            ->name('front.receipts-contest.receipts.send');

        Route::post('receipts/search/{field}/{type}', 'ItemsControllerContract@search')
            ->where('field', 'phone|email')
            ->where('type', 'winner|status')
            ->name('front.receipts-contest.receipts.search');

        Route::get('receipts/winners', 'ItemsControllerContract@getWinners')
            ->name('front.receipts-contest.receipts.winners.get');
    }
);
