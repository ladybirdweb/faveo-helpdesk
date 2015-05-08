<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\Priority;
use App\Model\Ticket_thread;

/**
 * ThreadController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class ThreadController extends Controller {

	/**
	 * get the values from ticket_thread Table and direct to view page
	 * @param type Ticket_thread $thread
	 * @param type Priority $priority
	 * @return type  Response
	 */
	public function getTickets(Ticket_thread $thread, Priority $priority) {
		try {
			/* get the values of Ticket_thread from Ticket_thread Table  */
			$threads = $thread->get();
			/* get the values of priority from Priority Table  */
			$priorities = $priority->get();
			/* Direct to view page */
			return view('themes.default1.admin.tickets.ticket', compact('threads', 'priorities'));
		} catch (Exception $e) {
			return view('404');
		}
	}
}
