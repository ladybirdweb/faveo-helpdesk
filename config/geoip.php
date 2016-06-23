<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Service
    |--------------------------------------------------------------------------
    |
    | Current only supports 'maxmind'.
    |
    */

    'service' => 'maxmind',

    /*
    |--------------------------------------------------------------------------
    | Services settings
    |--------------------------------------------------------------------------
    |
    | Service specific settings.
    |
    */

    'maxmind' => [
        'type'          => env('GEOIP_DRIVER', 'database'), // database or web_service
        'user_id'       => env('GEOIP_USER_ID'),
        'license_key'   => env('GEOIP_LICENSE_KEY'),
        'database_path' => storage_path('app/geoip.mmdb'),
        'update_url'    => 'https://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Location
    |--------------------------------------------------------------------------
    |
    | Return when a location is not found.
    |
    */

    'default_location' => [
        'ip'           => '127.0.0.0',
        'isoCode'      => 'IN',
        'country'      => 'INDIA',
        'city'         => 'Bangalore',
        'state'        => 'KT',
        'postal_code'  => '06510',
        'lat'          => 41.31,
        'lon'          => -72.92,
        'timezone'     => 'America/New_York',
        'continent'    => 'NA',
    ],

];
