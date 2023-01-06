<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// models
use App\Model\helpdesk\Priority;
use App\Model\helpdesk\Ticket_Thread;
// classes
use Exception;

/**
 * ThreadController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class ThreadController extends Controller
{
    /**
     * get the values from ticket_thread Table and direct to view page.
     *
     * @param type Ticket_thread $thread
     * @param type Priority      $priority
     *
     * @return type Response
     */
    public function getTickets(Ticket_Thread $thread, Priority $priority)
    {
        try {
            /* get the values of Ticket_thread from Ticket_thread Table  */
            $threads = $thread->get();
            /* get the values of priority from Priority Table  */
            $priorities = $priority->get();
            /* Direct to view page */
            return view('themes.default1.admin.helpdesk.tickets.ticket', compact('threads', 'priorities'));
        } catch (Exception $e) {
            return view('404');
        }
    }
}
