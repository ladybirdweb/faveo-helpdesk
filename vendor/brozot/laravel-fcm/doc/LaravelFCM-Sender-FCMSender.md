LaravelFCM\Sender\FCMSender
===============

Class FCMSender




* Class name: FCMSender
* Namespace: LaravelFCM\Sender
* Parent class: [LaravelFCM\Sender\BaseSender](LaravelFCM-Sender-BaseSender.md)



Constants
----------


### MAX_TOKEN_PER_REQUEST

    const MAX_TOKEN_PER_REQUEST = 1000





Properties
----------


### $client

    protected \Illuminate\Foundation\Application $client

Guzzle Client



* Visibility: **protected**


### $config

    protected array $config

configuration



* Visibility: **protected**


### $url

    protected mixed $url

url



* Visibility: **protected**


Methods
-------


### sendTo

    \LaravelFCM\Response\DownstreamResponse|null LaravelFCM\Sender\FCMSender::sendTo(String|array $to, \LaravelFCM\Message\Options|null $options, \LaravelFCM\Message\PayloadNotification|null $notification, \LaravelFCM\Message\PayloadData|null $data)

send a downstream message to

- a unique device with is registration Token
- or to multiples devices with an array of registrationIds

* Visibility: **public**


#### Arguments
* $to **String|array**
* $options **[LaravelFCM\Message\Options](LaravelFCM-Message-Options.md)|null**
* $notification **[LaravelFCM\Message\PayloadNotification](LaravelFCM-Message-PayloadNotification.md)|null**
* $data **[LaravelFCM\Message\PayloadData](LaravelFCM-Message-PayloadData.md)|null**



### sendToGroup

    \LaravelFCM\Response\GroupResponse LaravelFCM\Sender\FCMSender::sendToGroup($notificationKey, \LaravelFCM\Message\Options|null $options, \LaravelFCM\Message\PayloadNotification|null $notification, \LaravelFCM\Message\PayloadData|null $data)

Send a message to a group of devices identified with them notification key



* Visibility: **public**


#### Arguments
* $notificationKey **mixed**
* $options **[LaravelFCM\Message\Options](LaravelFCM-Message-Options.md)|null**
* $notification **[LaravelFCM\Message\PayloadNotification](LaravelFCM-Message-PayloadNotification.md)|null**
* $data **[LaravelFCM\Message\PayloadData](LaravelFCM-Message-PayloadData.md)|null**



### sendToTopic

    \LaravelFCM\Response\TopicResponse LaravelFCM\Sender\FCMSender::sendToTopic(\LaravelFCM\Message\Topics $topics, \LaravelFCM\Message\Options|null $options, \LaravelFCM\Message\PayloadNotification|null $notification, \LaravelFCM\Message\PayloadData|null $data)

Send message devices registered at a or more topics



* Visibility: **public**


#### Arguments
* $topics **[LaravelFCM\Message\Topics](LaravelFCM-Message-Topics.md)**
* $options **[LaravelFCM\Message\Options](LaravelFCM-Message-Options.md)|null**
* $notification **[LaravelFCM\Message\PayloadNotification](LaravelFCM-Message-PayloadNotification.md)|null**
* $data **[LaravelFCM\Message\PayloadData](LaravelFCM-Message-PayloadData.md)|null**



### getUrl

    string LaravelFCM\Sender\BaseSender::getUrl()

get the url



* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [LaravelFCM\Sender\BaseSender](LaravelFCM-Sender-BaseSender.md)




### __construct

    mixed LaravelFCM\Sender\BaseSender::__construct()

BaseSender constructor.



* Visibility: **public**
* This method is defined by [LaravelFCM\Sender\BaseSender](LaravelFCM-Sender-BaseSender.md)



