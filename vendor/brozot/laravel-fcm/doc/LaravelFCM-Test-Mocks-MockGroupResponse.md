LaravelFCM\Test\Mocks\MockGroupResponse
===============

Class MockGroupResponse **Only use it for testing**




* Class name: MockGroupResponse
* Namespace: LaravelFCM\Test\Mocks
* This class implements: [LaravelFCM\Response\GroupResponseContract](LaravelFCM-Response-GroupResponseContract.md)






Methods
-------


### setNumberSuccess

    mixed LaravelFCM\Test\Mocks\MockGroupResponse::setNumberSuccess($numberSuccess)

set number of success



* Visibility: **public**


#### Arguments
* $numberSuccess **mixed**



### numberSuccess

    integer LaravelFCM\Response\GroupResponseContract::numberSuccess()

Get the number of device reached with success



* Visibility: **public**
* This method is defined by [LaravelFCM\Response\GroupResponseContract](LaravelFCM-Response-GroupResponseContract.md)




### setNumberFailure

    mixed LaravelFCM\Test\Mocks\MockGroupResponse::setNumberFailure($numberFailures)

set number of failures



* Visibility: **public**


#### Arguments
* $numberFailures **mixed**



### numberFailure

    integer LaravelFCM\Response\GroupResponseContract::numberFailure()

Get the number of device which thrown an error



* Visibility: **public**
* This method is defined by [LaravelFCM\Response\GroupResponseContract](LaravelFCM-Response-GroupResponseContract.md)




### addTokenFailed

    mixed LaravelFCM\Test\Mocks\MockGroupResponse::addTokenFailed($tokenFailed)

add a token to the failed list



* Visibility: **public**


#### Arguments
* $tokenFailed **mixed**



### tokensFailed

    array LaravelFCM\Response\GroupResponseContract::tokensFailed()

Get all token in group that fcm cannot reach



* Visibility: **public**
* This method is defined by [LaravelFCM\Response\GroupResponseContract](LaravelFCM-Response-GroupResponseContract.md)



