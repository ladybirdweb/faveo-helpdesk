# NotificationPusher - Documentation

## APNS adapter

[APNS](http://developer.apple.com/library/ios/#documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Introduction.html) adapter is used to push notification to Apple devices.

### Basic notification push example

``` php
<?php

require_once '/path/to/vendor/autoload.php';

use Sly\NotificationPusher\PushManager,
    Sly\NotificationPusher\Adapter\Apns as ApnsAdapter,
    Sly\NotificationPusher\Collection\DeviceCollection,
    Sly\NotificationPusher\Model\Device,
    Sly\NotificationPusher\Model\Message,
    Sly\NotificationPusher\Model\Push
;

// First, instantiate the manager.
//
// Example for production environment:
// $pushManager = new PushManager(PushManager::ENVIRONMENT_PRODUCTION);
//
// Development one by default (without argument).
$pushManager = new PushManager(PushManager::ENVIRONMENT_DEV);

// Then declare an adapter.
$apnsAdapter = new ApnsAdapter(array(
    'certificate' => '/path/to/your/apns-certificate.pem',
));

// Set the device(s) to push the notification to.
$devices = new DeviceCollection(array(
    new Device('Token1'),
    // ...
));

// Then, create the push skel.
$message = new Message('This is a basic example of push.');

// Finally, create and add the push to the manager, and push it!
$push = new Push($apnsAdapter, $devices, $message);
$pushManager->add($push);
$pushManager->push();
```

### Custom notification push example

``` php
<?php

require_once '/path/to/vendor/autoload.php';

use Sly\NotificationPusher\PushManager,
    Sly\NotificationPusher\Adapter\Apns as ApnsAdapter,
    Sly\NotificationPusher\Collection\DeviceCollection,
    Sly\NotificationPusher\Model\Device,
    Sly\NotificationPusher\Model\Message,
    Sly\NotificationPusher\Model\Push
;

// First, instantiate the manager.
//
// Example for production environment:
// $pushManager = new PushManager(PushManager::ENVIRONMENT_PRODUCTION);
//
// Development one by default (without argument).
$pushManager = new PushManager(PushManager::ENVIRONMENT_DEV);

// Then declare an adapter.
$apnsAdapter = new ApnsAdapter(array(
    'certificate' => '/path/to/your/apns-certificate.pem',
    'passPhrase' => 'example',
));

// Set the device(s) to push the notification to.
$devices = new DeviceCollection(array(
    new Device('Token1', array('badge' => 5)),
    new Device('Token2', array('badge' => 1)),
    new Device('Token3'),
));

// Then, create the push skel.
$message = new Message('This is an example.', array(
    'badge' => 1,
    'sound' => 'example.aiff',

    'actionLocKey' => 'Action button title!',
    'locKey' => 'localized key',
    'locArgs' => array(
        'localized args',
        'localized args',
        'localized args'
    ),
    'launchImage' => 'image.jpg',

    'custom' => array('custom data' => array(
        'we' => 'want', 'send to app'
    ))
));

// Finally, create and add the push to the manager, and push it!
$push = new Push($apnsAdapter, $devices, $message);
$pushManager->add($push);
$pushManager->push(); // Returns a collection of notified devices
```

### Feedback example

The feedback service is used to list tokens of devices which not have your application anymore.

``` php
<?php

require_once '/path/to/vendor/autoload.php';

use Sly\NotificationPusher\PushManager,
    Sly\NotificationPusher\Adapter\Apns as ApnsAdapter
;

// First, instantiate the manager.
//
// Example for production environment:
// $pushManager = new PushManager(PushManager::ENVIRONMENT_PRODUCTION);
//
// Development one by default (without argument).
$pushManager = new PushManager(PushManager::ENVIRONMENT_DEV);

// Then declare an adapter.
$apnsAdapter = new ApnsAdapter(array(
    'certificate' => '/path/to/your/apns-certificate.pem',
));

$feedback = $pushManager->getFeedback($apnsAdapter); // Returns an array of Token + DateTime couples
```

## Documentation index

* [Installation](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/installation.md)
* [Getting started](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/getting-started.md)
* APNS adapter
* [GCM adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/gcm-adapter.md)
* [Create an adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/create-an-adapter.md)
* [Push from CLI](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/push-from-cli.md)
