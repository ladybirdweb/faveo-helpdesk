<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

/* include Priority Model */
use App\Model\Priority;

/* include Ticket_thread Model */
use App\Model\Ticket_thread;

class ThreadController extends Controller {

	/* get the values from ticket_thread Table and direct to view page  */

	public function getTickets(Ticket_thread $thread, Priority $priority)

	{
		try
		{
			/* get the values of Ticket_thread from Ticket_thread Table  */
			$threads = $thread->get();

			/* get the values of priority from Priority Table  */
			$priorities = $priority->get();

			/* Direct to view page */
			return view('themes.default1.admin.tickets.ticket', compact('threads','priorities'));
		}
		catch(Exception $e)
		{
			return view('404');
		}
	}
}
