# NotificationPusher - Documentation

## GCM adapter

[GCM](http://developer.android.com/google/gcm/gs.html) adapter is used to push notification to Google/Android devices.

### Custom notification push example

``` php
<?php

require_once '/path/to/vendor/autoload.php';

use Sly\NotificationPusher\PushManager,
    Sly\NotificationPusher\Adapter\Gcm as GcmAdapter,
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
$gcmAdapter = new GcmAdapter(array(
    'apiKey' => 'YourApiKey',
));

// Set the device(s) to push the notification to.
$devices = new DeviceCollection(array(
    new Device('Token1'),
    new Device('Token2'),
    new Device('Token3'),
));

// Then, create the push skel.
$message = new Message('This is an example.');

// Finally, create and add the push to the manager, and push it!
$push = new Push($gcmAdapter, $devices, $message);
$pushManager->add($push);
$pushManager->push(); // Returns a collection of notified devices
```

## Documentation index

* [Installation](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/installation.md)
* [Getting started](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/getting-started.md)
* [APNS adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/apns-adapter.md)
* GCM adapter
* [Create an adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/create-an-adapter.md)
* [Push from CLI](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/push-from-cli.md)
