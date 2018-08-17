# NotificationPusher - Documentation

## Push from CLI

For some reasons (tests or others), you could be happened to use pushing from CLI.

To do this, use `np` script (available at root directory) this way:

```
./np push <adapter> <token-or-registration-id> "Your message" --option1=value1 --option2=value2 ...
```

Each options matches with adapters required and optional ones.

Here is a concrete APNS adapter example:

```
./np push apns <token> "It's an example!" --certificate=/path/to/the/certificate.pem
```

Here is a concrete GCM adapter example:

```
./np push gcm <token> "It's an example!" --api-key=XXXXXXXXXX
```

## Documentation index

* [Installation](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/installation.md)
* [Getting started](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/getting-started.md)
* [APNS adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/apns-adapter.md)
* [GCM (FCM) adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/gcm-fcm-adapter.md)
* [Create an adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/create-an-adapter.md)
* Push from CLI
* [Facades](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/facades.md)
