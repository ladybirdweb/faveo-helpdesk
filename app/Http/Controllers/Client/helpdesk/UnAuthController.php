<?php

namespace App\Http\Controllers\Client\helpdesk;

// controllers
use App\Http\Controllers\Common\PhpMailController;
use App\Http\Controllers\Common\SettingsController;
use App\Http\Controllers\Controller;
// requests
use Illuminate\Http\Request;
use App\Http\Requests\helpdesk\ProfilePassword;
use App\Http\Requests\helpdesk\ProfileRequest;
use App\Http\Requests\helpdesk\TicketRequest;
// models
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
use App\User;
// classes
use Auth;
use Exception;
use Hash;
use Input;

/**
 * GuestController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class UnAuthController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return type void
     */
    public function __construct(PhpMailController $PhpMailController) {
        $this->PhpMailController = $PhpMailController;
    }

    /**
     * Post Check ticket.
     *
     * @param type CheckTicket   $request
     * @param type User          $user
     * @param type Tickets       $ticket
     * @param type Ticket_Thread $thread
     *
     * @return type Response
     */
    public function PostCheckTicket(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'email_address' => 'required|email',
                    'ticket_number' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput()
                            ->with('check', '1');
        }
        $Email = $request->input('email_address');
        $Ticket_number = $request->input('ticket_number');

        $ticket = Tickets::where('ticket_number', '=', $Ticket_number)->first();
        if ($ticket == null) {
            return \Redirect::route('form')->with('fails', 'There is no such Ticket Number');
        } else {
            $userId = $ticket->user_id;
            $user = User::where('id', '=', $userId)->first();
            if ($user->role == 'user') {
                $username = $user->user_name;
            } else {
                $username = $user->first_name . ' ' . $user->last_name;
            }
            if ($user->email != $Email) {
                return \Redirect::route('form')->with('fails', "Email didn't match with Ticket Number");
            } else {
                $code = $ticket->id;
                $code = \Crypt::encrypt($code);
//                $company = $this->company();
                $this->PhpMailController->sendmail(
                        $from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $username, 'email' => $user->email], $message = ['subject' => 'Ticket link Request [' . $Ticket_number . ']', 'scenario' => 'check-ticket'], $template_variables = ['user' => $username, 'ticket_link_with_number' => \URL::route('check_ticket', $code)]
                );
                return redirect()->back()
                                ->with('success', 'We have sent you a link by Email. Please click on that link to view ticket');
            }
        }
    }
    
    public function 

}