# Laravel-FCM

[![Build Status](https://travis-ci.org/brozot/Laravel-FCM.svg?branch=master)](https://travis-ci.org/brozot/Laravel-FCM) [![Coverage Status](https://coveralls.io/repos/github/brozot/Laravel-FCM/badge.svg?branch=master)](https://coveralls.io/github/brozot/Laravel-FCM?branch=master) [![Latest Stable Version](https://poser.pugx.org/brozot/laravel-fcm/v/stable)](https://packagist.org/packages/brozot/laravel-fcm) [![Total Downloads](https://poser.pugx.org/brozot/laravel-fcm/downloads)](https://packagist.org/packages/brozot/laravel-fcm)
[![License](https://poser.pugx.org/brozot/laravel-fcm/license)](https://packagist.org/packages/brozot/laravel-fcm)

## Introduction

Laravel-FCM is an easy to use package working with both Laravel and Lumen for sending push notification with [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging/) (FCM). 

It currently **only supports HTTP protocol** for :

- sending a downstream message to one or multiple devices
- managing groups and sending message to a group
- sending topics messages

> Note: The XMPP protocol is not currently supported.


## Installation

To get the latest version of Laravel-FCM on your project, require it from "composer":


	$ composer require brozot/laravel-fcm


Or you can add it directly in your composer.json file:


	{
    	"require": {
        	"brozot/laravel-fcm": "1.2.*"
    	}
	}


### Laravel

Register the provider directly in your app configuration file config/app.php `config/app.php`:

```php
'providers' => [
	// ...
	
	LaravelFCM\FCMServiceProvider::class 
]
```

Add the facade aliases in the same file:

```php
'aliases' => [
	...
	'FCM'      => LaravelFCM\Facades\FCM::class,
	'FCMGroup' => LaravelFCM\Facades\FCMGroup::class, // Optional
]
```

> Note: The `FCMGroup` facade is needed only if you want to manage groups messages in your application.

Publish the package config file using the following command:


	$ php artisan vendor:publish


### Lumen

Register the provider in your boostrap app file ```boostrap/app.php```

Add the following line in the "Register Service Providers"  section at the bottom of the file. 

```php
$app->register(LaravelFCM\FCMServiceProvider::class);
```

For facades, add the following lines in the section "Create The Application" . FCMGroup facade is only necessary if you want to use groups message in your application.

```php
class_alias(\LaravelFCM\Facades\FCM::class, 'FCM');
class_alias(\LaravelFCM\Facades\FCMGroup::class, 'FCMGroup');
```

Copy the config file ```fcm.php``` manually from the directory ```/vendor/brozot/laravel-fcm/config``` to the directory ```/config ``` (you may need to create this directory).


### Package Configuration

In your `.env` file, add the server key and the secret key for the Firebase Cloud Messaging:

```php
FCM_SERVER_KEY=my_secret_server_key
FCM_SENDER_ID=my_secret_sender_id
```

To get these keys, you must create a new application on the [firebase cloud messaging console](https://console.firebase.google.com/).

After the creation of your application on Firebase, you can find keys in `project settings -> cloud messaging`.


## Basic Usage

Two types of messages can be sent using Laravel-FCM:

- Notification messages, sometimes thought of as "display messages"
- Data messages, which are handled by the client app

More information is available in the [official documentation](https://firebase.google.com/docs/cloud-messaging/concept-options).


### Downstream Messages

A downstream message is a notification message, a data message, or both, that you send to a target device or to multiple target devices using its registration_Ids.

The following use statements are required for the examples below:

```php
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
```

#### Sending a Downstream Message to a Device

```php
$optionBuilder = new OptionsBuilder();
$optionBuilder->setTimeToLive(60*20);

$notificationBuilder = new PayloadNotificationBuilder('my title');
$notificationBuilder->setBody('Hello world')
				    ->setSound('default');
				    
$dataBuilder = new PayloadDataBuilder();
$dataBuilder->addData(['a_data' => 'my_data']);

$option = $optionBuilder->build();
$notification = $notificationBuilder->build();
$data = $dataBuilder->build();

$token = "a_registration_from_your_database";

$downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

$downstreamResponse->numberSuccess();
$downstreamResponse->numberFailure();
$downstreamResponse->numberModification();

//return Array - you must remove all this tokens in your database
$downstreamResponse->tokensToDelete(); 

//return Array (key : oldToken, value : new token - you must change the token in your database )
$downstreamResponse->tokensToModify(); 

//return Array - you should try to resend the message to the tokens in the array
$downstreamResponse->tokensToRetry();

// return Array (key:token, value:errror) - in production you should remove from your database the tokens
```

#### Sending a Downstream Message to Multiple Devices

```php
$optionBuilder = new OptionsBuilder();
$optionBuilder->setTimeToLive(60*20);

$notificationBuilder = new PayloadNotificationBuilder('my title');
$notificationBuilder->setBody('Hello world')
				    ->setSound('default');
				    
$dataBuilder = new PayloadDataBuilder();
$dataBuilder->addData(['a_data' => 'my_data']);

$option = $optionBuilder->build();
$notification = $notificationBuilder->build();
$data = $dataBuilder->build();

// You must change it to get your tokens
$tokens = MYDATABASE::pluck('fcm_token')->toArray();

$downstreamResponse = FCM::sendTo($tokens, $option, $notification);

$downstreamResponse->numberSuccess();
$downstreamResponse->numberFailure(); 
$downstreamResponse->numberModification();

//return Array - you must remove all this tokens in your database
$downstreamResponse->tokensToDelete(); 

//return Array (key : oldToken, value : new token - you must change the token in your database )
$downstreamResponse->tokensToModify(); 

//return Array - you should try to resend the message to the tokens in the array
$downstreamResponse->tokensToRetry();

// return Array (key:token, value:errror) - in production you should remove from your database the tokens present in this array 
$downstreamResponse->tokensWithError(); 
```

### Topics Messages

A topics message is a notification message, data message, or both, that you send to all the devices registered to this topic.

> Note: Topic names must be managed by your app and known by your server. The Laravel-FCM package or fcm doesn't provide an easy way to do that.

The following use statement is required for the examples below:

```php
use LaravelFCM\Message\Topics;
```

#### Sending a Message to a Topic

```php
$notificationBuilder = new PayloadNotificationBuilder('my title');
$notificationBuilder->setBody('Hello world')
				    ->setSound('default');
				    
$notification = $notificationBuilder->build();

$topic = new Topics();
$topic->topic('news');

$topicResponse = FCM::sendToTopic($topic, null, $notification, null)

$topicResponse->isSuccess();
$topicResponse->shouldRetry();
$topicResponse->error());
```

#### Sending a Message to Multiple Topics

It sends notification to devices registered at the following topics:

- news and economic
- news and cultural

> Note : Conditions for topics support two operators per expression

```php
$notificationBuilder = new PayloadNotificationBuilder('my title');
$notificationBuilder->setBody('Hello world')
				    ->setSound('default');
				    
$notification = $notificationBuilder->build();

$topic = new Topics();
$topic->topic('news')->andTopic(function($condition) {

	$condition->topic('economic')->orTopic('cultural');
	
});

$topicResponse = FCM::sendToTopic($topic, null, $notification, null);

$topicResponse->isSuccess();
$topicResponse->shouldRetry();
$topicResponse->error());

```

### Group Messages

#### Sending a Notification to a Group

```php
$notificationKey = ['a_notification_key'];


$notificationBuilder = new PayloadNotificationBuilder('my title');
$notificationBuilder->setBody('Hello world')
                        ->setSound('default');

$notification = $notificationBuilder->build();


$groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);

$groupResponse->numberSuccess();
$groupResponse->numberFailure();
$groupResponse->tokensFailed();
```


#### Creating a Group

```php
$tokens = ['a_registration_id_at_add_to_group'];
$groupName = "a_group";
$notificationKey

// Save notification key in your database you must use it to send messages or for managing this group
$notification_key = FCMGroup::createGroup($groupName, $tokens);
```

#### Adding Devices to a Group

```php
$tokens = ['a_registration_id_at_add_to_the_new_group'];
$groupName = "a_group";
$notificationKey = "notification_key_received_when_group_was_created";

$key = FCMGroup::addToGroup($groupName, $notificationKey, $tokens);
```

#### Deleting Devices from a Group

> Note if all devices are removed from the group, the group is automatically removed in "fcm".

```php
$tokens = ['a_registration_id_at_remove_from_the_group'];
$groupName = "a_group";
$notificationKey = "notification_key_received_when_group_was_created";

$key = FCMGroup::removeFromGroup($groupName, $notificationKey, $tokens);
```


## Options

Laravel-FCM supports options based on the options of Firebase Cloud Messaging. These options can help you to define the specificity of your notification.

You can construct an option as follows:

```php
$optionsBuilder = new OptionsBuilder();

$optionsBuilder->setTimeToLive(42*60)
                ->setCollapseKey('a_collapse_key');

$options = $optionsBuilder->build();
```

## Notification Messages

Notification payload is used to send a notification, the behaviour is defined by the App State and the OS of the receptor device.

**Notification messages are delivered to the notification tray when the app is in the background.** For apps in the foreground, messages are handled by these callbacks:

- didReceiveRemoteNotification: on iOS
- onMessageReceived() on Android. The notification key in the data bundle contains the notification.

See the [official documentation](https://firebase.google.com/docs/cloud-messaging/concept-options#notifications).


```php
$notificationBuilder = new PayloadNotificationBuilder();
$notificationBuilder->setTitle('title')
            		->setBody('body')
            		->setSound('sound')
            		->setBadge('badge');

$notification = $notificationBuilder->build();
```

## Data Messages

Set the data key with your custom key-value pairs to send a data payload to the client app. Data messages can have a 4KB maximum payload.

- **iOS**, FCM stores the message and delivers it **only when the app is in the foreground** and has established a FCM connection.
- **Android**, a client app receives a data message in onMessageReceived() and can handle the key-value pairs accordingly.

See the [official documentation](https://firebase.google.com/docs/cloud-messaging/concept-options#data_messages).


```php
$dataBuilder = new PayloadDataBuilder();
$dataBuilder->addData([
	'data_1' => 'first_data'
]);

$data = $dataBuilder->build();
```

## Notification & Data Messages

App behavior when receiving messages that include both notification and data payloads depends on whether the app is in the background or the foreground—essentially, whether or not it is active at the time of receipt ([source](https://firebase.google.com/docs/cloud-messaging/concept-options#messages-with-both-notification-and-data-payloads)).

- **Background**, apps receive notification payload in the notification tray, and only handle the data payload when the user taps on the notification.
- **Foreground**, your app receives a message object with both payloads available.


## Topics

For topics message, Laravel-FCM offers an easy to use api which abstract firebase conditions. To make the condition given for example in the firebase official documentation it must be done with Laravel-FCM like below:

**Official documentation condition**

```
'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics)
```

```php
$topics = new Topics();

$topics->topic('TopicA')
       ->andTopic(function($condition) {
	       $condition->topic('TopicB')->orTopic('TopicC');
       });
```


## Testing

For integration testing, you can mock the responses with mockery and Mocks provided by the package.

There are 3 kinds of "MockResponse" given by the package:

- MockDownstreamResponse
- MockGroupResponse
- MockTopicResponse

You can mock the FCM call as in the following example:

```php
$numberSucess = 2;
$mockResponse = new \LaravelFCM\Mocks\MockDownstreamResponse(numberSucess);

$mockResponse->addTokenToDelete('token_to_delete');
$mockResponse->addTokenToModify('token_to_modify', 'token_modified');
$mockResponse->setMissingToken(true);

$sender = Mockery::mock(\LaravelFCM\Sender\FCMSender::class);
$sender->shouldReceive('sendTo')->once()->andReturn($mockResponse);

$this->app->singleton('fcm.sender', function($app) use($sender) {
	return $sender;
});
```

## API Documentation

You can find more documentation about the API in the [API reference](./doc/Readme.md).


## Licence

This library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

Some of this documentation is coming from the official documentation. You can find it completely on the [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging/) Website.
