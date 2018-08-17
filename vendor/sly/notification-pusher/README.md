# NotificationPusher [![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/ph3nol/notificationpusher?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Standalone PHP library for easy devices message notifications push.

[![Latest Stable Version](https://img.shields.io/packagist/v/sly/notification-pusher.svg)](https://packagist.org/packages/sly/notification-pusher)
[![License](https://img.shields.io/packagist/l/sly/notification-pusher.svg)](https://packagist.org/packages/sly/notification-pusher)
[![Total Downloads](https://img.shields.io/packagist/dt/sly/notification-pusher.svg)](https://packagist.org/packages/sly/notification-pusher)
[![Build Status](https://secure.travis-ci.org/Ph3nol/NotificationPusher.png)](http://travis-ci.org/Ph3nol/NotificationPusher)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4f6f80c4-281a-4903-bf4c-1eb264995dbd/big.png)](https://insight.sensiolabs.com/projects/4f6f80c4-281a-4903-bf4c-1eb264995dbd)

**Feel free to contribute! Thanks.**

## Contributors

* [Cédric Dugat](https://github.com/Ph3nol) (Author / Lead developer)
* [Oleg Abrazhaev](https://github.com/seyfer) (Lead developer)
* [Community contributors](https://github.com/Ph3nol/NotificationPusher/graphs/contributors)

## Installation

```
composer require sly/notification-pusher
```

This repository uses PSR-0 autoload.
After installation with [composer](https://getcomposer.org/download/) please adjust you autoloading config if needed 
or `include vendor/autoload.php` in your index.php.

## Requirements

* PHP 5.6+
* PHP Curl and OpenSSL modules
* Specific adapters requirements (like APNS certificate, GCM (FCM) API key, etc.)

**WARNING** Version `v3.0` would support only php 7.0+. Please, update your composer config if needed.

## Today available adapters

* APNS (Apple)
* GCM (Android) and FCM (Android)

## Documentation and examples

* [Installation](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/installation.md)
* [Getting started](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/getting-started.md)
* [APNS adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/apns-adapter.md)
* [GCM (FCM) adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/gcm-fcm-adapter.md)
* [Create an adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/create-an-adapter.md)
* [Push from CLI](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/push-from-cli.md)
* [Facades](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/facades.md)

## Todo

* Add new features (custom APNS payloads, GCM and FCM custom options, etc.)
* Add new adapters (like Blackberry and Windows phones)
* Write more documentation and examples!
* Write more tests. (contributions are welcome!)

## 1.x users

Old version is still available from [1.x branch](https://github.com/Ph3nol/NotificationPusher/tree/1.x), with dedicated declared tag.


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/Ph3nol/notificationpusher/trend.png)](https://bitdeli.com/free "Bitdeli Badge")
