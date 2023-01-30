LaravelFCM\Response\TopicResponseContract
===============

Interface TopicResponseContract




* Interface name: TopicResponseContract
* Namespace: LaravelFCM\Response
* This is an **interface**






Methods
-------


### isSuccess

    boolean LaravelFCM\Response\TopicResponseContract::isSuccess()

true if topic sent with success



* Visibility: **public**




### error

    string LaravelFCM\Response\TopicResponseContract::error()

return error message
you should test if it's necessary to resent it



* Visibility: **public**




### shouldRetry

    boolean LaravelFCM\Response\TopicResponseContract::shouldRetry()

return true if it's necessary resent it using exponential backoff



* Visibility: **public**



