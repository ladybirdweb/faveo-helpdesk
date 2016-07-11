<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Response\DownstreamResponse;
//use LaravelFCM\Message\
//use LaravelFCM\Message\
use FCM;
use FCMGroup;

/**
 * **********************************************
 * PushNotificationController
 * **********************************************
 * This controller is used to send notification to FCM cloud which later will 
 * foreward notification to Mobile Application
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class PushNotificationController extends Controller {

    public function response() {
//        $notificationBuilder = new PayloadNotificationBuilder('my title');
//        $notificationBuilder->setBody('Hello world')
//                ->setSound('default');
//
//        $notification = $notificationBuilder->build();
//
//        $topic = new Topics();
//        $topic->topic('news')->andTopic(function($condition) {
//
//        $condition->topic('economic')->orTopic('cultural');
//
//        });
//        
//        $topicResponse = FCM::sendToTopic($topic, null, $notification, null);
//
//        $topicResponse->isSuccess();
//        $topicResponse->shouldRetry();
//        $topicResponse->error();








        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
                ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuiler->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $tokens = "a_registration_from_your_database";

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

//        $downstreamResponse = new DownstreamResponse($response, $tokens);

        dd($downstreamResponse);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

//return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

//return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();

//return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

// return Array (key:token, value:errror) - in production you should remove from your database the tokens
    }

}
