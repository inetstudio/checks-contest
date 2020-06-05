<?php

return [

    /*
     * Настройки изображений
     */

    'images' => [
        'quality' => 75,
        'conversions' => [
            'receipt' => [
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
