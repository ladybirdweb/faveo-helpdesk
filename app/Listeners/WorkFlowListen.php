<?php

namespace App\Listeners;

use App\Events\WorkFlowEvent;

class WorkFlowListen
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param WorkFlowListen $event
     *
     * @return void
     */
    public function handle(WorkFlowEvent $event)
    {
        $options = $event->options['values'];
        $ticket = $event->options['ticket'];
        $TicketController = new \App\Http\Controllers\Agent\helpdesk\TicketController();
        $workflow_ticket = new \App\Http\Controllers\Agent\helpdesk\TicketWorkflowController($TicketController);
        $values = $workflow_ticket->process($options);

        return $this->ticket($values, $ticket);
    }

    /**
     * update the ticket properties according to workflow.
     *
     * @param array $values
     * @param mixed $ticket
     *
     * @return mixed
     */
    public function ticket($values, $ticket)
    {
        //dd($values,$ticket);
        if (checkArray('department', $values)) {
            $ticket->dept_id = (int) $values['department'];
        }
        if (checkArray('helptopic', $values)) {
            $ticket->help_topic_id = $values['helptopic'];
        }
        if (checkArray('sla', $values)) {
            $ticket->sla = $values['sla'];
        }
        if (checkArray('team', $values)) {
            $ticket->team_id = $values['team'];
        }
        if (checkArray('agent', $values)) {
            $ticket->assigned_to = $values['agent'];
        }
        if (checkArray('priority', $values)) {
            $ticket->priority_id = $values['priority'];
        }
        if (checkArray('type', $values)) {
            $ticket->type = $values['type'];
        }
        if (checkArray('source', $values)) {
            $ticket->source = $values['source'];
        }
        if (checkArray('status', $values)) {
            $ticket->status = $values['status'];
        }

        return $ticket;
    }
}
