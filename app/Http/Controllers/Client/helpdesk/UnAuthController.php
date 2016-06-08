<?php

namespace App\Http\Controllers\Client\helpdesk;

// controllers
use App\Http\Controllers\Common\PhpMailController;
use App\Http\Controllers\Controller;
// requests
use App\Model\helpdesk\Email\Emails;
// models
use App\Model\helpdesk\Settings\CommonSettings;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Ticket\TicketToken;
use App\User;
use Hash;
// classes
use Illuminate\Http\Request;
use Input;
use Lang;

/**
 * GuestController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class UnAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type void
     */
    public function __construct(PhpMailController $PhpMailController)
    {
        $this->middleware('board');
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
    public function PostCheckTicket(Request $request)
    {
        try {
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
            $email = $request->input('email_address');
            $ticket_number = $request->input('ticket_number');
            // get user details
            $user_details = User::where('email', '=', $email)->first();
            // get ticket details
            $ticket = Tickets::where('ticket_number', '=', $ticket_number)->first();
            if ($ticket == null) {
                return \Redirect::route('form')->with('fails', Lang::get('lang.there_is_no_such_ticket_number'));
            }
            if ($ticket->user_id == $user_details->id) {
                if ($user_details->role == 'user') {
                    $username = $user_details->user_name;
                } else {
                    $username = $user_details->first_name.' '.$user_details->last_name;
                }
                // check for preentered ticket token
                $ticket_token = TicketToken::where('ticket_id', '=', $ticket->id)->first();
                if ($ticket_token) {
                    $token = $this->generate_random_ticket_token();
                    $hashed_token = \Hash::make($token);
                    $ticket_token->token = $hashed_token;
                    $ticket_token->save();
                } else {
                    $ticket_token = new TicketToken();
                    $ticket_token->ticket_id = $ticket->id;
                    $token = $this->generate_random_ticket_token();
                    $hashed_token = \Hash::make($token);
                    $ticket_token->token = $hashed_token;
                    $ticket_token->save();
                }
                try {
                    $this->PhpMailController->sendmail(
                            $from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $username, 'email' => $user_details->email], $message = ['subject' => 'Ticket link Request ['.$ticket_number.']', 'scenario' => 'check-ticket'], $template_variables = ['user' => $username, 'ticket_link_with_number' => url('show-ticket/'.$ticket->id.'/'.$token)]
                    );
                } catch (\Exception $e) {
                }

                return redirect()->back()
                                ->with('success', Lang::get('lang.we_have_sent_you_a_link_by_email_please_click_on_that_link_to_view_ticket'));
            } else {
                return \Redirect::route('form')->with('fails', Lang::get("lang.email_didn't_match_with_ticket_number"));
            }
        } catch (\Exception $e) {
            return \Redirect::route('form')->with('fails', $e->getMessage());
        }
    }

    /**
     * generate random string token for ticket.
     *
     * @param type $length
     *
     * @return string
     */
    public function generate_random_ticket_token($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * function to check the ticket without loggin In.
     *
     * @param type $ticket_id
     * @param type $token
     *
     * @return type view
     */
    public function showTicketCode($ticket_id, $token)
    {
        try {
            $check_token = TicketToken::where('ticket_id', '=', $ticket_id)->first();
            if (Hash::check($token, $check_token->token) == true) {
                $token_time = CommonSettings::where('option_name', '=', 'ticket_token_time_duration')->first();
                $time = $token_time->option_value;
                $new_time = date_add($check_token->updated_at, date_interval_create_from_date_string($time.' Hours'));
                if (date('Y-m-d H:i:s') > $new_time) {
                    return redirect()->route('form')->with('fails', Lang::get('lang.sorry_your_ticket_token_has_expired_please_try_to_resend_the_ticket_link_request'));
                }
                $tickets = Tickets::where('id', '=', $ticket_id)->first();

                return view('themes.default1.client.helpdesk.unauth.showticket', compact('tickets', 'token'));
            } else {
                return redirect()->route('form')->with('fails', Lang::get('lang.sorry_you_are_not_allowed_token_expired'));
            }
        } catch (Exception $ex) {
            return redirect()->route('form')->with('fails', $e->getMessage());
        }
    }

    /**
     * Store ratings of the user.
     *
     * @return type Redirect
     */
    public function rating($id, Request $request, \App\Model\helpdesk\Ratings\RatingRef $rating_ref)
    {
        foreach ($request->all() as $key => $value) {
            if (strpos($key, '_') !== false) {
                $ratName = str_replace('_', ' ', $key);
            } else {
                $ratName = $key;
            }
            $ratID = \App\Model\helpdesk\Ratings\Rating::where('name', '=', $ratName)->first();
            $ratingrefs = $rating_ref->where('rating_id', '=', $ratID->id)->where('ticket_id', '=', $id)->first();
            if ($ratingrefs !== null) {
                $ratingrefs->rating_id = $ratID->id;
                $ratingrefs->ticket_id = $id;

                $ratingrefs->thread_id = '0';
                $ratingrefs->rating_value = $value;
                $ratingrefs->save();
            } else {
                $rating_ref->rating_id = $ratID->id;
                $rating_ref->ticket_id = $id;

                $rating_ref->thread_id = '0';
                $rating_ref->rating_value = $value;
                $rating_ref->save();
            }
        }

        return redirect()->back()->with('Success', Lang::get('lang.thank_you_for_your_rating'));
    }

    /**
     * Store Client rating about reply of agent quality.
     *
     * @return type Redirect
     */
    public function ratingReply($id, Request $request, \App\Model\helpdesk\Ratings\RatingRef $rating_ref)
    {
        foreach ($request->all() as $key => $value) {
            $key1 = explode(',', $key);
            if (strpos($key1[0], '_') !== false) {
                $ratName = str_replace('_', ' ', $key1[0]);
            } else {
                $ratName = $key1[0];
            }
            $ratID = \App\Model\helpdesk\Ratings\Rating::where('name', '=', $ratName)->first();
            $ratingrefs = $rating_ref->where('rating_id', '=', $ratID->id)->where('thread_id', '=', $key1[1])->first();
            if ($ratingrefs !== null) {
                $ratingrefs->rating_id = $ratID->id;
                $ratingrefs->ticket_id = $id;
                $ratingrefs->thread_id = $key1[1];
                $ratingrefs->rating_value = $value;
                $ratingrefs->save();
            } else {
                $rating_ref->rating_id = $ratID->id;
                $rating_ref->ticket_id = $id;
                $rating_ref->thread_id = $key1[1];
                $rating_ref->rating_value = $value;
                $rating_ref->save();
            }
        }

        return redirect()->back()->with('Success', Lang::get('lang.thank_you_for_your_rating'));
    }

    /**
     * function to change the status of the ticket.
     *
     * @param type $status
     * @param type $id
     *
     * @return string
     */
    public function changeStatus($status, $id)
    {
        $tickets = Tickets::where('id', '=', $id)->first();
        $tickets->status = $status;
        $ticket_status = Ticket_Status::where('id', '=', $status)->first();
        if ($ticket_status->state == 'closed') {
            $tickets->closed = $ticket_status->id;
            $tickets->closed_at = date('Y-m-d H:i:s');
        }
        $tickets->save();
        $ticket_thread = Ticket_Thread::where('ticket_id', '=', $ticket_status->id)->first();
        $ticket_subject = $ticket_thread->title;

        $user = User::where('id', '=', $tickets->user_id)->first();

        $thread = new Ticket_Thread();
        $thread->ticket_id = $tickets->id;
        $thread->user_id = $tickets->user_id;
        $thread->is_internal = 1;
        $thread->body = $ticket_status->message.' '.$user->user_name;
        $thread->save();

        $email = $user->email;
        $user_name = $user->user_name;

        $ticket_number = $tickets->ticket_number;

        $sending_emails = Emails::where('department', '=', $ticket_status->dept_id)->first();
        if ($sending_emails == null) {
            $from_email = $this->system_mail();
        } else {
            $from_email = $sending_emails->id;
        }
        try {
            $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('0', $tickets->dept_id), $to = ['name' => $user_name, 'email' => $email], $message = ['subject' => $ticket_subject.'[#'.$ticket_number.']', 'scenario' => 'close-ticket'], $template_variables = ['ticket_number' => $ticket_number]);
        } catch (\Exception $e) {
            return 0;
        }

        return Lang::get('lang.your_ticket_has_been').' '.$ticket_status->state;
    }
}
