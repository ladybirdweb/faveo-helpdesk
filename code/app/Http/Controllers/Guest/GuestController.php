<?php
namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckTicket;
use App\Http\Requests\ProfilePassword;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\TicketRequest;
use App\Model\Manage\Help_topic;
use App\Model\Ticket\Tickets;
use App\Model\Ticket\Ticket_Thread;
use App\User;
use Auth;
use Hash;
use Input;

/**
 * GuestController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class GuestController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type void
	 */
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('role.user');
	}

	/**
	 * Get profile
	 * @return type Response
	 */
	public function getProfile() {
		$user = Auth::user();
		return view('themes.default1.client.guest-user.profile', compact('user'));
	}

	/**
	 * Save profile data
	 * @param type $id
	 * @param type ProfileRequest $request
	 * @return type Response
	 */
	public function postProfile($id, ProfileRequest $request) {
		$user = Auth::user();
		$user->gender = $request->input('gender');
		$user->save();
		if ($user->profile_pic == 'avatar5.png' || $user->profile_pic == 'avatar2.png') {
			if ($request->input('gender') == 1) {
				$name = 'avatar5.png';
				$destinationPath = 'dist/img';
				$user->profile_pic = $name;
			} elseif ($request->input('gender') == 0) {
				$name = 'avatar2.png';
				$destinationPath = 'dist/img';
				$user->profile_pic = $name;
			}
		}
		if (Input::file('profile_pic')) {
			//$extension = Input::file('profile_pic')->getClientOriginalExtension();
			$name = Input::file('profile_pic')->getClientOriginalName();
			$destinationPath = 'dist/img';
			$fileName = rand(0000, 9999) . '.' . $name;
			//echo $fileName;
			Input::file('profile_pic')->move($destinationPath, $fileName);
			$user->profile_pic = $fileName;
		} else {
			$user->fill($request->except('profile_pic', 'gender'))->save();
			return redirect('guest')->with('success', 'Profile Updated sucessfully');
		}
		if ($user->fill($request->except('profile_pic'))->save()) {
			return redirect('guest')->with('success', 'Profile Updated sucessfully');
		}
	}

	/**
	 * Get Ticket page
	 * @param type Help_topic $topic
	 * @return type Response
	 */
	public function getTicket(Help_topic $topic) {
		$topics = $topic->get();
		return view('themes.default1.client.guest-user.form', compact('topics'));
	}

	/**
	 * Get my ticket
	 * @param type Tickets $tickets
	 * @param type Ticket_Thread $thread
	 * @param type User $user
	 * @return type Response
	 */
	public function getMyticket(Tickets $tickets, Ticket_Thread $thread, User $user) {
		$id = Auth::user()->id;
		/* Get the user where id == $id */
		$user = $user->whereId($id)->first();
		/* Get the all tickets which belongs to the current user */
		$tickets = $tickets->where('user_id', $user->id)->get();
		//dd($tickets);
		/* get the ticket's id == ticket_id of thread  */
		$ticket = $tickets->where('user_id', $user->id)->first();
		/* get the thread of the selected ticket */
		$thread = $thread->where('ticket_id', $ticket->id)->first();
		return view('themes.default1.agent.ticket.ticket', compact('thread', 'tickets'));
	}

	/**
	 * Get ticket-thread
	 * @param type Ticket_Thread $thread
	 * @param type Tickets $tickets
	 * @param type User $user
	 * @return type Response
	 */
	public function thread(Ticket_Thread $thread, Tickets $tickets, User $user) {
		$user_id = Auth::user()->id;
		//dd($user_id);
		/* get the ticket's id == ticket_id of thread  */
		$tickets = $tickets->where('user_id', '=', $user_id)->first();
		//dd($ticket);
		$thread = $thread->where('ticket_id', $tickets->id)->first();
		//dd($thread);
		// $tickets = $tickets->whereId($id)->first();
		return view('themes.default1.agent.ticket.timeline', compact('thread', 'tickets'));
	}

	/**
	 * ticket Edit
	 * @return
	 */
	public function ticketEdit() {
	}

	/**
	 * Post porfile password
	 * @param type $id
	 * @param type ProfilePassword $request
	 * @return type Response
	 */
	public function postProfilePassword($id, ProfilePassword $request) {
		$user = Auth::user();
		//echo $user->password;
		if (Hash::check($request->input('old_password'), $user->getAuthPassword())) {
			$user->password = Hash::make($request->input('new_password'));
			$user->save();
			return redirect('guest')->with('success', 'Password Updated sucessfully');
		} else {
			return redirect('guest')->with('fails', 'Password was not Updated');
		}
	}

	/**
	 * Ticekt reply
	 * @param type Ticket_Thread $thread
	 * @param type TicketRequest $request
	 * @return type Response
	 */
	public function reply(Ticket_Thread $thread, TicketRequest $request) {
		$thread->ticket_id = $request->input('ticket_ID');
		$thread->title = $request->input('To');
		$thread->user_id = Auth::user()->id;
		$thread->body = $request->input('ReplyContent');
		$thread->poster = 'user';
		$thread->save();
		$ticket_id = $request->input('ticket_ID');
		$tickets = Tickets::where('id', '=', $ticket_id)->first();
		$thread = Ticket_Thread::where('ticket_id', '=', $ticket_id)->first();
		// return 'success';
		return Redirect("thread/" . $ticket_id);
	}

	/**
	 * Get Checked ticket
	 * @param type Tickets $ticket
	 * @param type User $user
	 * @return type response
	 */
	public function getCheckTicket(Tickets $ticket, User $user) {
		return view('themes.default1.client.guest-user.newticket', compact('ticket'));
	}

	/**
	 * Post Check ticket
	 * @param type CheckTicket $request
	 * @param type User $user
	 * @param type Tickets $ticket
	 * @param type Ticket_Thread $thread
	 * @return type Response
	 */
	public function PostCheckTicket(CheckTicket $request, User $user, Tickets $ticket, Ticket_Thread $thread) {
		try {
			$user = $user->where('email', $request->input('email'))->first();
			$tickets = $ticket->where('ticket_number', $request->input('ticket_number'))->first();
			if ($user && $tickets) {
				//$user = $user->where('email',$request->input('email'))->first();
				$user_id = $user->id;
				//$ticket = $ticket->where('user_id',$user_id)->first();
				//$ticket_number = $ticket->ticket_number;
				$thread = $thread->where('user_id', $user_id)->first();
				return view('themes.default1.client.guest-user.checkticket', compact('user', 'tickets', 'thread'));
			}
		} catch (Exception $e) {
			return redirect('checkticket')->with('fails', 'Enter valid Inputs');
		}
	}
}
