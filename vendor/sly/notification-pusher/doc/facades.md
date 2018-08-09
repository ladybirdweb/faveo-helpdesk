# NotificationPusher - Documentation

## Facades

In order to simplify lib usage some service facades were added. 
They would return Response object with all information about sent pushes.
Also, facades provide useful methods to filter successful and invalid tokens from responses.

## Basic usage example

### The Response

```
$response->getParsedResponses();
$response->getOriginalResponses();
$response->getPushCollection();
```

### Android facade

```
$android_api_key = 'key';

//get tokens list from your service
$tokensA = ['token1', 'token2'];

//get messages
$messages = [
    'hi Luc, it\'s test',
    'test noty 2',
];

//maybe you want some params
$params = [];

//init android facade service
$pushNotificationService = new GcmPushService(
    $android_api_key, PushManager::ENVIRONMENT_PROD
);

//push! you will get a Response with parsed and original response collections
//and with a push collection
$response = $pushNotificationService->push($tokensA, $messages, $params);

NOTE: if you need to pass not only data, but also notification array
use key notificationData in params, like $params[notificationData] = []
OR you could use optional GcmMessage class instead of Message and
use it's setter setNotificationData()

//easily access list of successful and invalid tokens
$invalidTokens    = $pushNotificationService->getInvalidTokens();
$successfulTokens = $pushNotificationService->getSuccessfulTokens();

die(dump($response, $invalidTokens, $successfulTokens));
```

### APNS facade

```
$certificatePath = 'cert.pem';
$passPhrase      = '';

//get tokens list
$tokensA = ['token1', 'token2'];

//get messages
$messages = [
    'hi Luc, it\'s test',
    'test noty 2',
];

//maybe you want some params
$params = [];

//init android facade service
$pushNotificationService = new ApnsPushService(
    $certificatePath, $passPhrase, PushManager::ENVIRONMENT_PROD
);

//push! you will get a Response with parsed and original response collections
//and with a push collection
$response = $pushNotificationService->push($tokensA, $messages, $params);

//you could get a feedback with list of successful tokens
$feedback = $pushNotificationService->feedback();

//or!

//easily access list of successful and invalid tokens
//WARNING! these methods would send feedback request anyway
$invalidTokens    = $pushNotificationService->getInvalidTokens();
$successfulTokens = $pushNotificationService->getSuccessfulTokens();

die(dump($response, $feedback, $invalidTokens, $successfulTokens));
```

## Documentation index

* [Installation](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/installation.md)
* [Getting started](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/getting-started.md)
* [APNS adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/apns-adapter.md)
* [GCM (FCM) adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/gcm-fcm-adapter.md)
* [Create an adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/create-an-adapter.md)
* [Push from CLI](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/push-from-cli.md)
* Facades