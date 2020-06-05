<?php

return [

    /*
     * Сервис детекции и распознавания штрих-кодов.
     */

    'recognize_barcodes_api' => [
        'url' => env('RECOGNIZE_BARCODES_API_URL', ''),
        'token' => env('RECOGNIZE_BARCODES_API_TOKEN', ''),
    ],

    /*
     * Сервис для получения информации по чеку по его qr-коду.
     */

    'fns_api' => [
        'url' => env('FNS_API_URL', ''),
        'token' => env('FNS_API_TOKEN', ''),
    ],
];
