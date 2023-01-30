Laravel Push Notification
=========

Package to enable sending push notifications to devices

Installation
----

Update your `composer.json` file to include this package as a dependency

Laravel 5 & Lumen

```json
"davibennun/laravel-push-notification": "dev-laravel5"
```
Laravel 4.*
```json
"davibennun/laravel-push-notification": "dev-master"
```

Register the PushNotification service provider by adding it to the providers array.
```php
'providers' => array(
	...
	'Davibennun\LaravelPushNotification\LaravelPushNotificationServiceProvider'
)
```

Alias the PushNotification facade by adding it to the aliases array in the `app/config/app.php` file.
```php
'aliases' => array(
	...
	'PushNotification' => 'Davibennun\LaravelPushNotification\Facades\PushNotification'
)
```

# Configuration

Copy the config file into your project by running: (Lumen users skip this)

Laravel 5
```php
php artisan vendor:publish --provider="Davibennun\LaravelPushNotification\LaravelPushNotificationServiceProvider" --tag="config"
```

Laravel 4.*
```
php artisan config:publish davibennun/laravel-push-notification
```

This will generate a config file like this
```php
array(
    'appNameIOS'=>array(
		'environment' => 'development',
		'certificate' => '/path/to/certificate.pem',
		'passPhrase'  => 'password',
		'service'     => 'apns'
    ),
    'appNameAndroid'=>array(
		'environment' => 'production',
		'apiKey'      => 'yourAPIKey',
		'service'     => 'gcm'
    )
);
```
Where all first level keys corresponds to an service configuration, each service has its own properties, android for instance have `apiKey` and IOS uses `certificate` and `passPhrase`. You can set as many services configurations as you want, one for each app.

##### Dont forget to set `service` key to identify IOS `'service'=>'apns'` and Android `'service'=>'gcm'`

##### The certificate path must be an absolute path, so in the configuration file you can use these:
```
//Path to the 'app' folder
'certificate'=>app_path().'/myCert.pem'
```
Laravel functions are also available `public_path()` `storage_path()` `base_path()`

# Usage
```php

PushNotification::app('appNameIOS')
                ->to($deviceToken)
                ->send('Hello World, i`m a push message');

```
Where app argument `appNameIOS` refers to defined service in config file.

### Dynamic configuration and Lumen users
You can set the app config array directly: (keep in mind the array schema)
```php
//iOS app
PushNotification::app(['environment' => 'development',
		'certificate' => '/path/to/certificate.pem',
		'passPhrase'  => 'password',
		'service'     => 'apns']);
//Android app		
PushNotification::app(['environment' => 'production',
		'apiKey'      => 'yourAPIKey',
		'service'     => 'gcm']);

```


To multiple devices and optioned message:
```php
$devices = PushNotification::DeviceCollection(array(
    PushNotification::Device('token', array('badge' => 5)),
    PushNotification::Device('token1', array('badge' => 1)),
    PushNotification::Device('token2')
));
$message = PushNotification::Message('Message Text',array(
    'badge' => 1,
    'sound' => 'example.aiff',
    
    'actionLocKey' => 'Action button title!',
    'locKey' => 'localized key',
    'locArgs' => array(
        'localized args',
        'localized args',
    ),
    'launchImage' => 'image.jpg',
    
    'custom' => array('custom data' => array(
        'we' => 'want', 'send to app'
    ))
));

$collection = PushNotification::app('appNameIOS')
    ->to($devices)
    ->send($message);

// get response for each device push
foreach ($collection->pushManager as $push) {
    $response = $push->getAdapter()->getResponse();
}

// access to adapter for advanced settings
$push = PushNotification::app('appNameAndroid');
$push->adapter->setAdapterParameters(['sslverifypeer' => false]);
```
This package is wrapps [Notification Package] and adds some flavor to it.

#### Usage advice
This package should be used with [Laravel Queues], so pushes dont blocks the user and are processed in the background, meaning a better flow.



[Notification Package]:https://github.com/Ph3nol/NotificationPusher
[Laravel Queues]:http://laravel.com/docs/queues
