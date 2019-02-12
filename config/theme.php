<?php

return [
    'default' => env('THEME', 'default1'),

    'fallback' => 'default1',

    'themes' => [

        'default1' => [
            'title' => 'Default',
            'path' => resource_path('views/themes/default1'),
        ]
    ],
];
