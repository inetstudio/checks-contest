<?php

return [

    /*
     * Расширение файла конфигурации app/config/filesystems.php
     * добавляет локальные диски для хранения изображений чеков
     */

    'receipts_contest_receipts' => [
        'driver' => 'local',
        'root' => storage_path('app/public/receipts_contest/receipts'),
        'url' => env('APP_URL').'/storage/receipts_contest/receipts',
        'visibility' => 'public',
    ],

];
