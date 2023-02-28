# NotificationPusher - Documentation

## Getting started

First, we are going to discover this library entities:

* Models (messages, pushes, devices)
* Adapters (APNS, GCM etc.)
* The Manager

Here is the basic principle of a notification push:

A **push** has 3 main elements: a composed **message**, some defined **devices** to notify
and an **adapter** matching with these devices.
The **manager** has to collect all push notifications and send them.

Here is how to translate this with code (just a little not-working example):

``` php
<?php

// First, instantiate the manager and declare an adapter.
$pushManager    = new PushManager();
$exampleAdapter = new ApnsAdapter();

// Set the device(s) to push the notification to.
$devices = new DeviceCollection(array(
    new Device('Token1'),
    new Device('Token2'),
    new Device('Token3'),
    // ...
));

// Then, create the push skel.
$message = new Message('This is an example.');

// Finally, create and add the push to the manager, and push it!
$push = new Push($exampleAdapter, $devices, $message);
$pushManager->add($push);
$pushManager->push();
```

## More about the Message entity

Some general options can be passed to the message entity and be used by adapters.
A message pushed from APNS adapter can comport a "badge" or "sound" information which will be set with
instance constructor second argument:

``` php
<?php

$message = new Message('This is an example.', array(
    'badge' => 1,
    'sound' => 'example.aiff',
    // ...
));
```

## More about the Device entity

The device can comport some dedicated informations that could be used by adapters.
For example, APNS adapter could want to know a device badge status for incrementing it with message's one.

Here is an example of this:

``` php
<?php

$message = new Message('This is an example.', array(
    'badge' => 1,
    // ...
));

$devices = new DeviceCollection(array(
    new Device('Token1', array('badge' => 5)),
    // ...
));
```

## Documentation index

* [Installation](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/installation.md)
* Getting started
* [APNS adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/apns-adapter.md)
* [GCM adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/gcm-adapter.md)
* [Create an adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/create-an-adapter.md)
* [Push from CLI](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/push-from-cli.md)
