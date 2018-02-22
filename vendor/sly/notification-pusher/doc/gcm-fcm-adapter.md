# NotificationPusher - Documentation

## GCM (FCM) adapter

[GCM](http://developer.android.com/google/gcm/gs.html) adapter is used to push notification to Google/Android devices.
[FCM](https://firebase.google.com/docs/cloud-messaging/) is supported. Please see [this comment](https://github.com/Ph3nol/NotificationPusher/pull/141#issuecomment-318896948) for explanation.

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
// $pushManager = new PushManager(PushManager::ENVIRONMENT_PROD);
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

$params = [];

NOTE: if you need to pass not only data, but also notification array
use key notificationData in params, like $params[notificationData] = []
OR you could use optional GcmMessage class instead of Message and
use it's setter setNotificationData()

// Then, create the push skel.
$message = new Message('This is an example.', $params);

// Finally, create and add the push to the manager, and push it!
$push = new Push($gcmAdapter, $devices, $message);
$pushManager->add($push);
$pushManager->push(); // Returns a collection of notified devices

// each response will contain also 
// the data of the overall delivery
foreach($push->getResponses() as $token => $response) {
    // > $response
    // Array
    // (
    //     [message_id] => fake_message_id
    //     [multicast_id] => -1
    //     [success] => 1
    //     [failure] => 0
    //     [canonical_ids] => 0
    // )
}
```

## Documentation index

* [Installation](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/installation.md)
* [Getting started](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/getting-started.md)
* [APNS adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/apns-adapter.md)
* GCM (FCM) adapter
* [Create an adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/create-an-adapter.md)
* [Push from CLI](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/push-from-cli.md)
* [Facades](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/facades.md)