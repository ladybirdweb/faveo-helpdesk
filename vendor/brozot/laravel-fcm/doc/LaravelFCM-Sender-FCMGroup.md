LaravelFCM\Sender\FCMGroup
===============

Class FCMGroup




* Class name: FCMGroup
* Namespace: LaravelFCM\Sender
* Parent class: [LaravelFCM\Sender\BaseSender](LaravelFCM-Sender-BaseSender.md)



Constants
----------


### CREATE

    const CREATE = "create"





### ADD

    const ADD = "add"





### REMOVE

    const REMOVE = "remove"





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


### createGroup

    null LaravelFCM\Sender\FCMGroup::createGroup($notificationKeyName, array $registrationIds)

Create a group



* Visibility: **public**


#### Arguments
* $notificationKeyName **mixed**
* $registrationIds **array**



### addToGroup

    null LaravelFCM\Sender\FCMGroup::addToGroup($notificationKeyName, $notificationKey, array $registrationIds)

add registrationId to a existing group



* Visibility: **public**


#### Arguments
* $notificationKeyName **mixed**
* $notificationKey **mixed**
* $registrationIds **array** - &lt;p&gt;registrationIds to add&lt;/p&gt;



### removeFromGroup

    null LaravelFCM\Sender\FCMGroup::removeFromGroup($notificationKeyName, $notificationKey, array $registeredIds)

remove registrationId to a existing group

>Note: if you remove all registrationIds the group is automatically deleted

* Visibility: **public**


#### Arguments
* $notificationKeyName **mixed**
* $notificationKey **mixed**
* $registeredIds **array** - &lt;p&gt;registrationIds to remove&lt;/p&gt;



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



