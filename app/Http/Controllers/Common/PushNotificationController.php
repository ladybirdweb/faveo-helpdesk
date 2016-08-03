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

    public function response($token, User $user) {
    }
    
    /**
     * function to get the fcm token from the api under a user.
     * @param \Illuminate\Http\Request $request
     * @return type
     */
    public function fcmToken(Request $request, User $user) {
    }

}
