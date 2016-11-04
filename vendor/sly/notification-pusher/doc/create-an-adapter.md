# NotificationPusher - Documentation

## Create an adapter

To create your own adapter, just create a class with taking care to extends `\Sly\NotificationPusher\Adapter\BaseAdapter`,
which implicitly implements `\Sly\NotificationPusher\Adapter\AdapterInterface` which contains some required methods:

* `push`: contains the adapter logic to push notifications
* `supports`: return the token condition for using the adapter
* `getDefaultParameters`: returns default parameters used by the adapter
* `getRequiredParameters`: returns required parameters used by the adapter

Feel free to observe [existent adapters](https://github.com/Ph3nol/NotificationPusher/tree/master/src/Sly/NotificationPusher/Adapter) for concrete example.

## Documentation index

* [Installation](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/installation.md)
* [Getting started](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/getting-started.md)
* [APNS adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/apns-adapter.md)
* [GCM adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/gcm-adapter.md)
* Create an adapter
* [Push from CLI](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/push-from-cli.md)
