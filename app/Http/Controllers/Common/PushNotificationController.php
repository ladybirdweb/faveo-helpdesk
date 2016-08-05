<?php

namespace App\Http\Controllers\Common;

// Controllers
use App\Http\Controllers\Controller;
// Requests
use App\User;
// Models
use FCM;
// classes
use Illuminate\Http\Request;

/**
 * **********************************************
 * PushNotificationController
 * **********************************************
 * This controller is used to send notification to FCM cloud which later will
 * foreward notification to Mobile Application.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class PushNotificationController extends Controller
{
    public function response($token, User $user)
    {
    }

    /**
     * function to get the fcm token from the api under a user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return type
     */
    public function fcmToken(Request $request, User $user)
    {
    }
}
