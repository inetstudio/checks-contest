<?php

return [

    /*
     * Сервис детекции и распознавания штрих-кодов.
     */

    'recognize_barcodes_api' => [
        'url' => env('RECOGNIZE_BARCODES_API_URL', ''),
        'token' => env('RECOGNIZE_BARCODES_API_TOKEN', ''),
    ],
];
