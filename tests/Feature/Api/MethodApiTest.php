<?php

namespace Tests\Feature\Api;

use TestCase;

class MethodApiTest extends TestCase
{
    /**
     * test authenticating.
     */
    public function testMethodAuthenticate()
    {
        $url = url('api/v1/authenticate');
        $user = $this->user();
        $response = $this->json('GET', $url, [
            'username' => $user->user_name,
            'password' => 'secret',
        ]);
        $response
                ->assertStatus(500)
//                ->assertJsonFragment([
//                    'token',
//                    'user_id',
//                ])
;
    }

    /**
     * testMethod creating ticket.
     */
    public function testMethodCreate()
    {
        $url = url('/api/v1/helpdesk/create');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $response = $this->call('GET', $url, [
            'user_id'   => $user->id,
            'body'      => 'Testing the unit cases',
            'email'     => $user->email,
            'first_name'=> $user->first_name,
            'helptopic' => 1,
            'priority'  => 1,
            'sla'       => 1,
            'subject'   => 'Testin Unit Cases',
        ]);
        $response
                ->assertStatus(500);
    }

    /**
     * creating user.
     *
     * @return object
     */
    public function user()
    {
        $user = factory(\App\User::class)->create();

        return $user;
    }

    /**
     * authenticating user.
     *
     * @param \App\User $user
     */
    public function authenticate(\App\User $user)
    {
        return \JWTAuth::setToken(\JWTAuth::fromUser($user));
    }

    public function testMethodRegister()
    {
        $url = url('/api/v1/register');
        $user = factory(\App\User::class)->make();
        $response = $this->call('GET', $url, [
            'username'  => $user->user_name,
            'email'     => $user->email,
            'password'  => 'secrete',
            'first_name'=> $user->first_name,
            'last_name' => $user->first_name,

        ]);
        $response
                ->assertStatus(500);
    }

//    public function testMethodAuthenticated(){
//        $url = url('api/v1/authenticate/user');
//        $user = \App\User::orderBy('id','desc')->first();
//        $auth = $this->authenticate($user);
//        $response = $this->json('GET', $url, [],['Authorization'=>'Bearer '.$auth->getToken()->get()]);
//        $response
//                ->assertStatus(200)
//                ->assertJsonFragment([
//                    'user',
//                ])
//        ;
//    }

    public function testMethodUrl()
    {
        $url = url('api/v1/helpdesk/url');
        $response = $this->json('POST', $url, [
            'url'=> faveoUrl('/'),
            ]);
        $response
                ->assertStatus(500);
    }

    public function testMethodReply()
    {
        $url = url('api/v1/helpdesk/reply');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('GET', $url, [
            'ticket_ID'    => $ticket->id,
            'reply_content'=> 'Replied',
            ]);
        $response
                ->assertStatus(500);
    }

    public function testMethodEditTicket()
    {
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('GET', $url, [
            'ticket_id'      => $ticket->id,
            'subject'        => 'New Title',
            'help_topic'     => $ticket->help_topic_id,
            'ticket_type'    => $ticket->type,
            'ticket_source'  => $ticket->source,
            'ticket_priority'=> 1,
            'sla_plan'       => $ticket->sla,
            ]);
        $response
                ->assertStatus(500);
    }

    public function testMethodDeleteTicket()
    {
        $url = url('api/v1/helpdesk/delete');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('GET', $url, [
            'ticket_id'=> $ticket->id,
            ]);
        $response
                ->assertStatus(500);
    }

    public function testMethodOpenTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/open?token='.$token);

        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodUnAssignedTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/unassigned?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodClosedTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/closed?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetAllAgents()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/agents?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetAllTeams()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/teams?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetCustomersByTerm()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/customers?token='.$token);
        $response = $this->json('POST', $url, ['search'=>'d']);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetCustomerSpecific()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/customers-custom?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetCustomerById()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $client = \App\User::where('role', 'user')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/customer?token='.$token);
        $response = $this->json('POST', $url, [
            'user_id'=> $client->id,
        ]);
        $response
                ->assertStatus(500);
    }

    public function testMethodTicketSearch()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/ticket-search?token='.$token);
        $response = $this->json('POST', $url, ['search'=>'a']);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetThreadByTicketId()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/ticket-thread?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'id'=> $ticket->id,
            ]);
        $response
                ->assertStatus(500);
    }

    public function testMethodTicketAssign()
    {
        $url = url('api/v1/helpdesk/assign');
        $user = \App\User::orderBy('id', 'desc')->first();
        $agent = \App\User::where('role', '!=', 'user')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('GET', $url, [
            'ticket_id'=> $ticket->id,
            'user'     => $agent->id,
            ]);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetHelpTopics()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/help-topic?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetSla()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/sla-plan?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetPriority()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/priority?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetDepartment()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/department?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetAllTickets()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/tickets?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetInbox()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/inbox?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetTrash()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/trash?token='.$token);
        $response = $this->json('POST', $url);
        $response
                ->assertStatus(500);
    }

    public function testMethodPostInternalNote()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/internal-note?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('GET', $url, [
            'ticketid'=> $ticket->id,
            'userid'  => $user->id,
            'body'    => 'This is an internal note',
            ]);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetTicketByAgent()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $agent = \App\User::where('role', '!=', 'user')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/my-tickets-agent?token='.$token);
        $response = $this->json('POST', $url, ['user_id'=>$agent->id]);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetTicketByUser()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $agent = \App\User::where('role', '=', 'user')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/my-tickets-user?token='.$token);
        $response = $this->json('POST', $url, ['user_id'=>$agent->id]);
        $response
                ->assertStatus(500);
    }

    public function testMethodPostCollaborator()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/create?token='.$token);
        $response = $this->json('GET', $url, [
            'ticket_id'=> $ticket->id,
            'email'    => $this->user()->email,
        ]);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetCollaboratorBySearch()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/collaborator/search?token='.$token);
        $response = $this->json('POST', $url, ['term'=>'s']);
        $response
                ->assertStatus(500);
    }

    public function testMethodGetCollaboratorWithTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/get-ticket?token='.$token);
        $response = $this->json('GET', $url, ['ticket_id'=>$ticket->id]);
        $response
                ->assertStatus(500);
    }

    public function testMethodRemoveCollaboratorFromTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/remove?token='.$token);
        $response = $this->json('GET', $url, [
            'ticket_id'=> $ticket->id,
            'email'    => 'testMethod@testMethod@example.com',
            ]);
        $response
                ->assertStatus(500);
    }

//    public function testMethodGetTicketWithFilters(){
//        $user = \App\User::orderBy('id','desc')->first();
//        $agent = \App\User::where('role','=','user')->first();
//        $auth = $this->authenticate($user);
//        $token = $auth->getToken()->get();
//        $url = url('api/v1/helpdesk/tickets2?token='.$token);
//        $response = $this->json('GET', $url,['user_id'=>$agent->id]);
//        $response
//                ->assertStatus(200)
//                ->assertJsonMissing([
//                    'error',
//                ])
//        ;
//    }
}
