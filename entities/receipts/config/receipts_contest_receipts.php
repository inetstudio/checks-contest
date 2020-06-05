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

    'mails' => [
        'status' => [
            'moderation' => [
                'subject' => 'Ваш чек отправлен на проверку',
            ],
            'approved' => [
                'subject' => 'Ваш чек одобрен',
            ],
            'preliminarily_approved' => [
                'subject' => 'Ваш чек одобрен',
            ],
            'rejected' => [
                'subject' => 'Ваш чек отклонен',
            ],
        ],
        'win' => [
            'main' => [
                'subject' => 'Вы выиграли приз',
            ],
        ],
    ],
];
