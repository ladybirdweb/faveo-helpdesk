LaravelFCM\Test\Mocks\MockTopicResponse
===============

Class MockTopicResponse **Only use it for testing**




* Class name: MockTopicResponse
* Namespace: LaravelFCM\Test\Mocks
* This class implements: [LaravelFCM\Response\TopicResponseContract](LaravelFCM-Response-TopicResponseContract.md)






Methods
-------


### setSuccess

    mixed LaravelFCM\Test\Mocks\MockTopicResponse::setSuccess($messageId)

if success set a message id



* Visibility: **public**


#### Arguments
* $messageId **mixed**



### isSuccess

    boolean LaravelFCM\Response\TopicResponseContract::isSuccess()

true if topic sent with success



* Visibility: **public**
* This method is defined by [LaravelFCM\Response\TopicResponseContract](LaravelFCM-Response-TopicResponseContract.md)




### setError

    mixed LaravelFCM\Test\Mocks\MockTopicResponse::setError($error)

set error



* Visibility: **public**


#### Arguments
* $error **mixed**



### error

    string LaravelFCM\Response\TopicResponseContract::error()

return error message
you should test if it's necessary to resent it



* Visibility: **public**
* This method is defined by [LaravelFCM\Response\TopicResponseContract](LaravelFCM-Response-TopicResponseContract.md)




### shouldRetry

    boolean LaravelFCM\Response\TopicResponseContract::shouldRetry()

return true if it's necessary resent it using exponential backoff



* Visibility: **public**
* This method is defined by [LaravelFCM\Response\TopicResponseContract](LaravelFCM-Response-TopicResponseContract.md)



