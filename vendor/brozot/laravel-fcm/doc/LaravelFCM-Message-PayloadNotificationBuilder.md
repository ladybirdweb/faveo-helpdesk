LaravelFCM\Message\PayloadNotificationBuilder
===============

Class PayloadNotificationBuilder

Official google documentation :


* Class name: PayloadNotificationBuilder
* Namespace: LaravelFCM\Message







Methods
-------


### __construct

    mixed LaravelFCM\Message\PayloadNotificationBuilder::__construct(String $title)

Title must be present on android notification and ios (watch) notification



* Visibility: **public**


#### Arguments
* $title **String**



### setTitle

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setTitle(String $title)

Indicates notification title. This field is not visible on iOS phones and tablets.

but it is required for android

* Visibility: **public**


#### Arguments
* $title **String**



### setBody

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setBody(String $body)

Indicates notification body text.



* Visibility: **public**


#### Arguments
* $body **String**



### setIcon

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setIcon(String $icon)

Supported Android
Indicates notification icon. example : Sets value to myicon for drawable resource myicon.



* Visibility: **public**


#### Arguments
* $icon **String**



### setSound

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setSound(String $sound)

Indicates a sound to play when the device receives a notification.

Supports default or the filename of a sound resource bundled in the app.

* Visibility: **public**


#### Arguments
* $sound **String**



### setBadge

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setBadge(String $badge)

Supported Ios

Indicates the badge on the client app home icon.

* Visibility: **public**


#### Arguments
* $badge **String**



### setTag

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setTag(String $tag)

Supported Android

Indicates whether each notification results in a new entry in the notification drawer on Android.
If not set, each request creates a new notification.
If set, and a notification with the same tag is already being shown, the new notification replaces the existing one in the notification drawer.

* Visibility: **public**


#### Arguments
* $tag **String**



### setColor

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setColor(String $color)

Supported Android

Indicates color of the icon, expressed in #rrggbb format

* Visibility: **public**


#### Arguments
* $color **String**



### setClickAction

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setClickAction(String $action)

Indicates the action associated with a user click on the notification



* Visibility: **public**


#### Arguments
* $action **String**



### setTitleLocationKey

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setTitleLocationKey(String $titleKey)

Indicates the key to the title string for localization.



* Visibility: **public**


#### Arguments
* $titleKey **String**



### setTitleLocationArgs

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setTitleLocationArgs(mixed $titleArgs)

Indicates the string value to replace format specifiers in the title string for localization.



* Visibility: **public**


#### Arguments
* $titleArgs **mixed**



### setBodyLocationKey

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setBodyLocationKey(String $bodyKey)

Indicates the key to the body string for localization.



* Visibility: **public**


#### Arguments
* $bodyKey **String**



### setBodyLocationArgs

    \LaravelFCM\Message\PayloadNotificationBuilder LaravelFCM\Message\PayloadNotificationBuilder::setBodyLocationArgs(mixed $bodyArgs)

Indicates the string value to replace format specifiers in the body string for localization.



* Visibility: **public**


#### Arguments
* $bodyArgs **mixed**



### getTitle

    null|String LaravelFCM\Message\PayloadNotificationBuilder::getTitle()

Get title



* Visibility: **public**




### getBody

    null|String LaravelFCM\Message\PayloadNotificationBuilder::getBody()

Get body



* Visibility: **public**




### getIcon

    null|String LaravelFCM\Message\PayloadNotificationBuilder::getIcon()

Get Icon



* Visibility: **public**




### getSound

    null|String LaravelFCM\Message\PayloadNotificationBuilder::getSound()

Get Sound



* Visibility: **public**




### getBadge

    null|String LaravelFCM\Message\PayloadNotificationBuilder::getBadge()

Get Badge



* Visibility: **public**




### getTag

    null|String LaravelFCM\Message\PayloadNotificationBuilder::getTag()

Get Tag



* Visibility: **public**




### getColor

    null|String LaravelFCM\Message\PayloadNotificationBuilder::getColor()

Get Color



* Visibility: **public**




### getClickAction

    null|String LaravelFCM\Message\PayloadNotificationBuilder::getClickAction()

Get ClickAction



* Visibility: **public**




### getBodyLocationKey

    null|String LaravelFCM\Message\PayloadNotificationBuilder::getBodyLocationKey()

Get BodyLocationKey



* Visibility: **public**




### getBodyLocationArgs

    null|String|array LaravelFCM\Message\PayloadNotificationBuilder::getBodyLocationArgs()

Get BodyLocationArgs



* Visibility: **public**




### getTitleLocationKey

    string LaravelFCM\Message\PayloadNotificationBuilder::getTitleLocationKey()

Get TitleLocationKey



* Visibility: **public**




### getTitleLocationArgs

    null|String|array LaravelFCM\Message\PayloadNotificationBuilder::getTitleLocationArgs()

GetTitleLocationArgs



* Visibility: **public**




### build

    \LaravelFCM\Message\PayloadNotification LaravelFCM\Message\PayloadNotificationBuilder::build()

Build an PayloadNotification



* Visibility: **public**



