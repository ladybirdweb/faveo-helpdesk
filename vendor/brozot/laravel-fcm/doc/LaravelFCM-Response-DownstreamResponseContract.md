LaravelFCM\Response\DownstreamResponseContract
===============

Interface DownstreamResponseContract




* Interface name: DownstreamResponseContract
* Namespace: LaravelFCM\Response
* This is an **interface**






Methods
-------


### merge

    mixed LaravelFCM\Response\DownstreamResponseContract::merge(\LaravelFCM\Response\DownstreamResponse $response)

Merge two response



* Visibility: **public**


#### Arguments
* $response **[LaravelFCM\Response\DownstreamResponse](LaravelFCM-Response-DownstreamResponse.md)**



### numberSuccess

    integer LaravelFCM\Response\DownstreamResponseContract::numberSuccess()

Get the number of device reached with success



* Visibility: **public**




### numberFailure

    integer LaravelFCM\Response\DownstreamResponseContract::numberFailure()

Get the number of device which thrown an error



* Visibility: **public**




### numberModification

    integer LaravelFCM\Response\DownstreamResponseContract::numberModification()

Get the number of device that you need to modify their token



* Visibility: **public**




### tokensToDelete

    array LaravelFCM\Response\DownstreamResponseContract::tokensToDelete()

get token to delete

remove all tokens returned by this method in your database

* Visibility: **public**




### tokensToModify

    array LaravelFCM\Response\DownstreamResponseContract::tokensToModify()

get token to modify

key: oldToken
value: new token

find the old token in your database and replace it with the new one

* Visibility: **public**




### tokensToRetry

    array LaravelFCM\Response\DownstreamResponseContract::tokensToRetry()

Get tokens that you should resend using exponential backoof



* Visibility: **public**




### tokensWithError

    array LaravelFCM\Response\DownstreamResponseContract::tokensWithError()

Get tokens that thrown an error

key : token
value : error

In production, remove these tokens from you database

* Visibility: **public**




### hasMissingToken

    boolean LaravelFCM\Response\DownstreamResponseContract::hasMissingToken()

check if missing tokens was given to the request
If true, remove all the empty token in your database



* Visibility: **public**



