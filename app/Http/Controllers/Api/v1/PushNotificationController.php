<?php

namespace App\Http\Controllers\Api\v1;

// Controllers
use App\Http\Controllers\Controller;
// Requests
use Illuminate\Http\Request;
// Models
use App\User;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Ticket\Ticket_Thread;
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

    public function Response($token, $body, $ticket_id = null) {

        $optionBuiler = new OptionsBuilder();
        $optionBuiler->setTimeToLive(60 * 60);

        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setBody($body)
                ->setSound('default')
                ->setIcon('ic_stat_f1')
                ->setClickAction('OPEN_ACTIVITY_1');

        if($ticket_id != null) {
            $ticket_data = Tickets::where('id', '=', $ticket_id )->first();
            $thread_data = Ticket_Thread::where('ticket_id', '=', $ticket_id)->first();
            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['ticket_id' => $ticket_id]);
            $dataBuilder->addData(['ticket_number' => $ticket_data->ticket_number]);
            $dataBuilder->addData(['ticket_opened_by' => $ticket_data->user_id]);
            $dataBuilder->addData(['ticket_subject' => $thread_data->title]);
        }

        $option = $optionBuiler->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $tokens = $token;

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        // $downstreamResponse = new DownstreamResponse($response, $tokens);

        // dd($downstreamResponse);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
        // return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();
        // return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();
        // return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();
        // return Array (key:token, value:errror) - in production you should remove from your database the tokens
    }
    
    /**
     * function to get the fcm token from the api under a user.
     * @param \Illuminate\Http\Request $request
     * @return type
     */
    public function fcmToken(Request $request, User $user) {
        // get the requested details 
        $user_id = $request->input('user_id');
        $fcm_token = $request->input('fcm_token');
        // check for all the valid details
        if($user_id != null && $user_id != "" && $fcm_token != null && $fcm_token != "") {
            // search the user_id in database
            $user = $user->where('id', '=', $user_id)->first();
            if($user != null) {
                $user->fcm_token = $fcm_token;
                $user->save();
                // success response for success case
                return ['response' => 'success'];
            } else {
                // failure respunse for invalid user_id in the system
                return ['response' => 'fail', 'reason' => 'Invalid user_id'];
            }
        } else {
            // failure respunse for invalid input credentials
            return ['response' => 'fail', 'reason' => 'Invalid Credentials'];
        }
    }

}
