LaravelFCM\Response\GroupResponse
===============

Class GroupResponse




* Class name: GroupResponse
* Namespace: LaravelFCM\Response
* Parent class: [LaravelFCM\Response\BaseResponse](LaravelFCM-Response-BaseResponse.md)



Constants
----------


### FAILED_REGISTRATION_IDS

    const FAILED_REGISTRATION_IDS = "failed_registration_ids"





### SUCCESS

    const SUCCESS = 'success'





### FAILURE

    const FAILURE = 'failure'





### ERROR

    const ERROR = "error"





### MESSAGE_ID

    const MESSAGE_ID = "message_id"







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



### logResponse

    mixed LaravelFCM\Response\BaseResponse::logResponse()

Log the response



* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [LaravelFCM\Response\BaseResponse](LaravelFCM-Response-BaseResponse.md)




### numberSuccess

    integer LaravelFCM\Response\GroupResponse::numberSuccess()

Get the number of device reached with success



* Visibility: **public**




### numberFailure

    integer LaravelFCM\Response\GroupResponse::numberFailure()

Get the number of device which thrown an error



* Visibility: **public**




### tokensFailed

    array LaravelFCM\Response\GroupResponse::tokensFailed()

Get all token in group that fcm cannot reach



* Visibility: **public**




### isJsonResponse

    mixed LaravelFCM\Response\BaseResponse::isJsonResponse(\GuzzleHttp\Psr7\Response $response)

Check if the response given by fcm is parsable



* Visibility: **private**
* This method is defined by [LaravelFCM\Response\BaseResponse](LaravelFCM-Response-BaseResponse.md)


#### Arguments
* $response **GuzzleHttp\Psr7\Response**


