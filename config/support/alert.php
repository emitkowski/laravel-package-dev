<?php

/*
 * Alert Service Settings
 *
 */

return [
    'enabled' => [
        'email' => env('ALERT_ENABLED_EMAIL', true),
        'text' => env('ALERT_ENABLED_TEXT', true),
    ],
    'type' => [
        'webops' => [
            'email' => env('ALERT_TYPE_WEBOPS_EMAIL'),
            'level' => 'Critical',
            'subject' => [
                'header' => env('ALERT_TYPE_WEBOPS_SUBJECT_HEADER', '(MyApp)')
            ]
        ]
    ]
];

