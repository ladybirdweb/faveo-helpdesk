<?php

namespace App\Http\Controllers\Common;

// Controllers
use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
// Models
use App\User;
// classes
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Response\DownstreamResponse;
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
    
    /**
     * function to get the fcm token from the api under a user.
     * @param \Illuminate\Http\Request $request
     * @return type
     */
    public function fcmToken(Request $request) {
        return "success 123";
//        // get the requested details 
//        $user_id = $request->input('user_id');
//        $fcm_token = $request->input('fcm_token');
//        // check for all the valid details
//        if($user_id != null && $user_id != "" && $fcm_token != null && $fcm_token != "") {
//            // search the user_id in database
//            $user = User::where('id', '=', $user_id)->first();
//            if($user != null) {
//                // success response for success case
//                return ['response' => 'success'];
//            } else {
//                // failure respunse for invalid user_id in the system
//                return ['response' => 'fail', 'reason' => 'Invalid user_id'];
//            }
//        } else {
//            // failure respunse for invalid input credentials
//            return ['response' => 'fail', 'reason' => 'Invalid Credentials'];
//        }
    }

}
