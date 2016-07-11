LaravelFCM\Response\DownstreamResponse
===============

Class DownstreamResponse




* Class name: DownstreamResponse
* Namespace: LaravelFCM\Response
* Parent class: [LaravelFCM\Response\BaseResponse](LaravelFCM-Response-BaseResponse.md)



Constants
----------


### MULTICAST_ID

    const MULTICAST_ID = 'multicast_id'





### CANONICAL_IDS

    const CANONICAL_IDS = "canonical_ids"





### RESULTS

    const RESULTS = "results"





### MISSING_REGISTRATION

    const MISSING_REGISTRATION = "MissingRegistration"





### MESSAGE_ID

    const MESSAGE_ID = "message_id"





### REGISTRATION_ID

    const REGISTRATION_ID = "registration_id"





### NOT_REGISTERED

    const NOT_REGISTERED = "NotRegistered"





### INVALID_REGISTRATION

    const INVALID_REGISTRATION = "InvalidRegistration"





### UNAVAILABLE

    const UNAVAILABLE = "Unavailable"





### DEVICE_MESSAGE_RATE_EXCEEDED

    const DEVICE_MESSAGE_RATE_EXCEEDED = "DeviceMessageRateExceeded"





### INTERNAL_SERVER_ERROR

    const INTERNAL_SERVER_ERROR = "InternalServerError"





### SUCCESS

    const SUCCESS = 'success'





### FAILURE

    const FAILURE = 'failure'





### ERROR

    const ERROR = "error"







Methods
-------


### __construct

    mixed LaravelFCM\Response\BaseResponse::__construct(\GuzzleHttp\Psr7\Response $response)

BaseResponse constructor.



* Visibility: **public**
* This method is defined by [LaravelFCM\Response\BaseResponse](LaravelFCM-Response-BaseResponse.md)


#### Arguments
* $response **GuzzleHttp\Psr7\Response**



### parseResponse

    mixed LaravelFCM\Response\BaseResponse::parseResponse(array $responseInJson)

parse the response



* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [LaravelFCM\Response\BaseResponse](LaravelFCM-Response-BaseResponse.md)


#### Arguments
* $responseInJson **array**



### merge

    mixed LaravelFCM\Response\DownstreamResponse::merge(\LaravelFCM\Response\DownstreamResponse $response)

Merge two response



* Visibility: **public**


#### Arguments
* $response **[LaravelFCM\Response\DownstreamResponse](LaravelFCM-Response-DownstreamResponse.md)**



### numberSuccess

    integer LaravelFCM\Response\DownstreamResponse::numberSuccess()

Get the number of device reached with success



* Visibility: **public**




### numberFailure

    integer LaravelFCM\Response\DownstreamResponse::numberFailure()

Get the number of device which thrown an error



* Visibility: **public**




### numberModification

    integer LaravelFCM\Response\DownstreamResponse::numberModification()

Get the number of device that you need to modify their token



* Visibility: **public**




### tokensToDelete

    array LaravelFCM\Response\DownstreamResponse::tokensToDelete()

get token to delete

remove all tokens returned by this method in your database

* Visibility: **public**




### tokensToModify

    array LaravelFCM\Response\DownstreamResponse::tokensToModify()

get token to modify

key: oldToken
value: new token

find the old token in your database and replace it with the new one

* Visibility: **public**




### tokensToRetry

    array LaravelFCM\Response\DownstreamResponse::tokensToRetry()

Get tokens that you should resend using exponential backoof



* Visibility: **public**




### tokensWithError

    array LaravelFCM\Response\DownstreamResponse::tokensWithError()

Get tokens that thrown an error

key : token
value : error

In production, remove these tokens from you database

* Visibility: **public**




### hasMissingToken

    boolean LaravelFCM\Response\DownstreamResponse::hasMissingToken()

check if missing tokens was given to the request
If true, remove all the empty token in your database



* Visibility: **public**




### isJsonResponse

    mixed LaravelFCM\Response\BaseResponse::isJsonResponse(\GuzzleHttp\Psr7\Response $response)

Check if the response given by fcm is parsable



* Visibility: **private**
* This method is defined by [LaravelFCM\Response\BaseResponse](LaravelFCM-Response-BaseResponse.md)


#### Arguments
* $response **GuzzleHttp\Psr7\Response**



### logResponse

    mixed LaravelFCM\Response\BaseResponse::logResponse()

Log the response



* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [LaravelFCM\Response\BaseResponse](LaravelFCM-Response-BaseResponse.md)



