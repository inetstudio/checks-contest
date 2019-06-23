<?php

return [

    'dates' => [
        'start' => '2019-01-01',
        'end' => '2019-01-31',
    ],

    /*
     * Настройки изображений
     */

    'images' => [
        'quality' => 75,
        'conversions' => [
            'check' => [
                'images' => [
                    'default' => [
                        [
                            'name' => 'admin_index_thumb',
                            'crop' => [
                                'width' => 100,
                                'height' => 100,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
