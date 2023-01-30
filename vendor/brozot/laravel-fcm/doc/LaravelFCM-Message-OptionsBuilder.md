LaravelFCM\Message\OptionsBuilder
===============

Builder for creation of options used by FCM

Class OptionsBuilder


* Class name: OptionsBuilder
* Namespace: LaravelFCM\Message







Methods
-------


### setCollapseKey

    \LaravelFCM\Message\OptionsBuilder LaravelFCM\Message\OptionsBuilder::setCollapseKey(String $collapseKey)

This parameter identifies a group of messages
A maximum of 4 different collapse keys is allowed at any given time.



* Visibility: **public**


#### Arguments
* $collapseKey **String**



### setPriority

    \LaravelFCM\Message\OptionsBuilder LaravelFCM\Message\OptionsBuilder::setPriority(String $priority)

Sets the priority of the message. Valid values are "normal" and "high."
By default, messages are sent with normal priority



* Visibility: **public**


#### Arguments
* $priority **String**



### setContentAvailable

    \LaravelFCM\Message\OptionsBuilder LaravelFCM\Message\OptionsBuilder::setContentAvailable(boolean $contentAvailable)

support only Android and Ios

An inactive client app is awoken.
On iOS, use this field to represent content-available in the APNS payload.
On Android, data messages wake the app by default.
On Chrome, currently not supported.

* Visibility: **public**


#### Arguments
* $contentAvailable **boolean**



### setDelayWhileIdle

    \LaravelFCM\Message\OptionsBuilder LaravelFCM\Message\OptionsBuilder::setDelayWhileIdle(boolean $delayWhileIdle)

When this parameter is set to true, it indicates that the message should not be sent until the device becomes active.



* Visibility: **public**


#### Arguments
* $delayWhileIdle **boolean**



### setTimeToLive

    \LaravelFCM\Message\OptionsBuilder LaravelFCM\Message\OptionsBuilder::setTimeToLive(integer $timeToLive)

This parameter specifies how long the message should be kept in FCM storage if the device is offline



* Visibility: **public**


#### Arguments
* $timeToLive **integer** - &lt;p&gt;(in second) min:0 max:2419200&lt;/p&gt;



### setRestrictedPackageName

    \LaravelFCM\Message\OptionsBuilder LaravelFCM\Message\OptionsBuilder::setRestrictedPackageName(string $restrictedPackageName)

This parameter specifies the package name of the application where the registration tokens must match in order to receive the message.



* Visibility: **public**


#### Arguments
* $restrictedPackageName **string**



### setDryRun

    \LaravelFCM\Message\OptionsBuilder LaravelFCM\Message\OptionsBuilder::setDryRun(boolean $isDryRun)

This parameter, when set to true, allows developers to test a request without actually sending a message.

It should only be used for the development

* Visibility: **public**


#### Arguments
* $isDryRun **boolean**



### getCollapseKey

    null|string LaravelFCM\Message\OptionsBuilder::getCollapseKey()

Get the collapseKey



* Visibility: **public**




### getPriority

    null|string LaravelFCM\Message\OptionsBuilder::getPriority()

Get the priority



* Visibility: **public**




### isContentAvailable

    boolean LaravelFCM\Message\OptionsBuilder::isContentAvailable()

is content available



* Visibility: **public**




### isDelayWhileIdle

    boolean LaravelFCM\Message\OptionsBuilder::isDelayWhileIdle()

is delay white idle



* Visibility: **public**




### getTimeToLive

    null|integer LaravelFCM\Message\OptionsBuilder::getTimeToLive()

get time to live



* Visibility: **public**




### getRestrictedPackageName

    null|string LaravelFCM\Message\OptionsBuilder::getRestrictedPackageName()

get restricted package name



* Visibility: **public**




### isDryRun

    boolean LaravelFCM\Message\OptionsBuilder::isDryRun()

is dry run



* Visibility: **public**




### build

    \LaravelFCM\Message\Options LaravelFCM\Message\OptionsBuilder::build()

build an instance of Options



* Visibility: **public**



