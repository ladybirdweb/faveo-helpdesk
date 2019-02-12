<?php
/**
 * Created by PhpStorm.
 * User: mjasan
 * Date: 11.2.2019
 * Time: 18:06
 */

return [
    'default' => env('THEME', 'default1'),

    'fallback' => 'default1',

    'themes' => [

        'default1' =>[
            'title' => 'Default',
            'path' => resource_path('views/themes/default1'),
        ],

        'geodeticca' =>[
            'title' => 'Geodeticca',
            'path' => resource_path('views/themes/geodeticca'),
        ],
    ],
];
