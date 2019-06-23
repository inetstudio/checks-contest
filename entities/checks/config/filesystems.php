<?php

return [

    /*
     * Расширение файла конфигурации app/config/filesystems.php
     * добавляет локальные диски для хранения изображений чеков
     */

    'checks_contest_checks' => [
        'driver' => 'local',
        'root' => storage_path('app/public/checks_contest/checks'),
        'url' => env('APP_URL').'/storage/checks_contest/checks',
        'visibility' => 'public',
    ],

];
