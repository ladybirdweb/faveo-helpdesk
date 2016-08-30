<?php

namespace App\Plugins\Zapier\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Plugins\Zapier\Model\Zapier;

class ZapierController extends Controller {

    public function zapier(Request $requests) {
//        $req = $requests->all();
//        $json = json_encode($req);
        $request = $this->getRequest();
        $app = $request['app'];
        
        /**
         * check app is active
         */
        if ($this->checkApp($app) == true) {
            $controller = $this->chooseApp($app, $request);
            $response = $this->createTicket($controller);
            $this->auditLog($response . " ticket has created");
        }
    }

    /**
     * Get the dummy response
     * @return array
     */
    public function getRequest($json='') {
        $json = '{"app":"happy_fox_chat","message":"Chat conversation by vijay (vijaysebastian111@gmail.com) on Aug 23rd 2016\n\n\nvijay : dscghsd - 03:21 PM\nvijay (Agent) : dcbdsh - 03:22 PM\n\n\nStats:\nUrl: http:\/\/localhost\/FaveoVersions\/faveo-helpdesk\/public\/\nWaiting Time: 3 seconds\nChat Duration: 3 seconds\nWebsite Profile: Lady\nOperating System: Mac OS X 10.11\nBrowser: Chrome 52.0\n","email":"vijaysebastian111@gmail.com","name":"vijay"}';
        $array = json_decode($json, true);
        return $array;
    }
    /**
     * check the app
     * @param string $app
     * @return boolean
     */
    public function checkApp($app) {
        $zapiers = new Zapier();
        $check = $zapiers->status($app);
        if ($check == false) {
            $this->auditLog("$app is inactive");
        }
        return $check;
    }

    /**
     * choose the application from zapier
     * @param string $app
     * @param array $request
     * @return \App\Plugins\Zapier\Controllers\HappyFoxChat\ProcessController
     */
    public function chooseApp($app, $request) {
        switch ($app) {
            case 'happy_fox_chat' :
                $controller = new \App\Plugins\Zapier\Controllers\HappyFoxChat\ProcessController($request);
                return $controller;
        }
    }

    /**
     * get the \App\Http\Controllers\Agent\helpdesk\TicketController instance
     * @return \App\Http\Controllers\Agent\helpdesk\TicketController
     */
    public function ticketController() {
        $PhpMailController = new \App\Http\Controllers\Common\PhpMailController();
        $NotificationController = new \App\Http\Controllers\Common\NotificationController();
        $ticket_controller = new \App\Http\Controllers\Agent\helpdesk\TicketController($PhpMailController, $NotificationController);
        return $ticket_controller;
    }

    /**
     * create ticket in system
     * @param object $controller
     */
    public function createTicket($controller) {
        $ticket = $this->ticketController();
        $emailadd = $controller->email();
        $username = $controller->email();
        $subject = $controller->subject();
        $body = $controller->message();
        $phone = $controller->phone();
        $phonecode = $controller->phoneCode();
        $mobile_number = $controller->mobile();
        $helptopic = $ticket->getSystemDefaultHelpTopic();
        $sla = $ticket->getSystemDefaultSla();
        $priority = $ticket->getSystemDefaultPriority();
        $source = $ticket->getSourceByname('chat')->id;
        $dept = $ticket->getSystemDefaultDepartment();
        //dd($emailadd, $username, $subject, $body, $phone, $phonecode, $mobile_number, $helptopic, $sla, $priority, $source, $headers = [], $dept, $assignto = NULL, $from_data = [], $auto_response = '');
        $result = $ticket->create_user($emailadd, $username, $subject, $body, $phone, $phonecode, $mobile_number, $helptopic, $sla, $priority, $source, $headers = [], $dept, $assignto = NULL, $from_data = [], $auto_response = '', $status = '');
        if (is_array($result)) {
            $this->socialChannel($result, $controller);
        }
        return json_encode($result);
    }

    /**
     * convert data to proper array
     * @param array $result
     * @param object $controller
     */
    public function socialChannel($result, $controller) {
        $array['channel'] = $controller->channel();
        $array['via'] = $controller->via();
        $array['message_id'] = $this->lastTicket($result);
        $array['user_id'] = $this->findUserFromTicketCreateUserId($result);
        $array['ticket_id'] = $this->lastTicket($result);
        $array['username'] = $this->findUserFromTicketCreateUsername($result);
        $array['posted_at'] = date('Y-m-d H:m:i');
        $this->updateSocialChannel($array);
    }

    /**
     * get the ticket id from the ticket create result
     * @param array $result
     * @return integer
     */
    public function lastTicket($result) {
        $ticket = $this->findTicketFromTicketCreateUser($result);
        if ($ticket) {
            $ticket_id = $ticket->id;
            return $ticket_id;
        }
    }

    /**
     * get the user id from ticket create result
     * @param array $result
     * @return integer
     */
    public function findUserFromTicketCreateUserId($result = []) {
        $ticket = $this->findTicketFromTicketCreateUser($result);
        if ($ticket) {
            $userid = $ticket->user_id;
            return $userid;
        }
    }

    /**
     * get user name from ticket create result
     * @param array $result
     * @return string
     */
    public function findUserFromTicketCreateUsername($result = []) {
        $ticket = $this->findTicketFromTicketCreateUser($result);
        if ($ticket) {
            $userid = $ticket->user_id;
            $user = \App\User::find($userid);
            if ($user) {
                return $user->user_name;
            }
        }
    }

    /**
     * get the ticket object
     * @param array $result
     * @return \Illuminate\Database\Eloquent\Model | NULL
     */
    public function findTicketFromTicketCreateUser($result = []) {
        $ticket_number = $this->checkArray('0', $result);
        if ($ticket_number !== "") {
            $tickets = new \App\Model\helpdesk\Ticket\Tickets();
            $ticket = $tickets->where('ticket_number', $ticket_number)->first();
            if ($ticket) {
                return $ticket;
            }
        }
    }

    /**
     * checking the array has key
     * @param string $key
     * @param array $array
     * @return string
     */
    public function checkArray($key, $array) {
        $value = "";
        if (array_key_exists($key, $array)) {
            $value = $array[$key];
        }
        return $value;
    }

    /**
     * update the social_channel table
     * @param array $array
     */
    public function updateSocialChannel($array) {
        $social_channel = new \App\Plugins\Social\Model\SocialChannel();
        $social_channel->create($array);
    }
    /**
     * auditing the logs
     * @param string $message
     */
    public function auditLog($message) {
        \Log::useDailyFiles(storage_path() . "/logs/zapier/zapier.log");
        \Log::info($message);
    }

}
