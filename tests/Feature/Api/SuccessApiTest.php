<?php

namespace Tests\Api\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use TestCase;

class SuccessApiTest extends TestCase
{
    //use DatabaseMigrations;

    /**
     * test authenticating.
     */
    public function testAuthenticate()
    {
        $url = url('api/v1/authenticate');
        $user = $this->user();
        $response = $this->json('POST', $url, [
            'username' => $user->user_name,
            'password' => 'secret',
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    'token',
                    'user_id',
                ]);
    }

    /**
     * test creating ticket.
     */
    public function testCreate()
    {
        $url = url('/api/v1/helpdesk/create');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $response = $this->call('POST', $url, [
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
                ->assertStatus(200)
                ->assertJsonFragment([
                    'success',
                ]);
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

    public function userMake()
    {
        $user = factory(\App\User::class)->make();

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

    public function testRegister()
    {
        $url = url('/api/v1/register');
        $user = factory(\App\User::class)->make();
        $response = $this->call('POST', $url, [
            'username'  => $user->user_name,
            'email'     => $user->email,
            'password'  => 'secrete',
            'first_name'=> $user->first_name,
            'last_name' => $user->first_name,

        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'user',
                ]);
    }

//    public function testAuthenticated(){
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

    public function testUrl()
    {
        $url = url('api/v1/helpdesk/url');
        $response = $this->json('GET', $url, [
            'url'=> faveoUrl('/'),
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'result',
                ]);
    }

    public function testReply()
    {
        $url = url('api/v1/helpdesk/reply');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_ID'    => $ticket->id,
            'reply_content'=> 'Replied',
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'result',
                ]);
    }

    public function testEditTicket()
    {
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'      => $ticket->id,
            'subject'        => 'New Title',
            'help_topic'     => $ticket->help_topic_id,
            'ticket_type'    => $ticket->type,
            'ticket_source'  => $ticket->source,
            'ticket_priority'=> 1,
            'sla_plan'       => $ticket->sla,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'result',
                ]);
    }

    public function testDeleteTicket()
    {
        $url = url('api/v1/helpdesk/delete');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
            ]);
        $response
                ->assertStatus(200)
                ->assertExactJson([
                    'result'=> 'your tickets has been deleted',
                ]);
    }

    public function testOpenTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/open?token='.$token);

        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    'current_page',
                    'data',
                    'path',
                ]);
    }

    public function testUnAssignedTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/unassigned?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    'current_page',
                    'data',
                    'path',
                ]);
    }

    public function testClosedTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/closed?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    'current_page',
                    'data',
                    'path',
                ]);
    }

    public function testGetAllAgents()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/agents?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'account_status',
                ]);
    }

    public function testGetAllTeams()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/teams?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'name',
                ]);
    }

    public function testGetCustomersByTerm()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/customers?token='.$token);
        $response = $this->json('GET', $url, ['search'=>'d']);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'result',
                ]);
    }

    public function testGetCustomerSpecific()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/customers-custom?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'current_page',
                ]);
    }

    public function testGetCustomerById()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $client = \App\User::where('role', 'user')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/customer?token='.$token);
        $response = $this->json('GET', $url, [
            'user_id'=> $client->id,
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'account_status',
                ]);
    }

    public function testTicketSearch()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/ticket-search?token='.$token);
        $response = $this->json('GET', $url, ['search'=>'a']);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'result',
                ]);
    }

    public function testGetThreadByTicketId()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/ticket-thread?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('GET', $url, [
            'id'=> $ticket->id,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'body',
                ]);
    }

    public function testTicketAssign()
    {
        $url = url('api/v1/helpdesk/assign');
        $user = \App\User::orderBy('id', 'desc')->first();
        $agent = \App\User::where('role', '!=', 'user')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
            'user'     => $agent->id,
            ]);
        $response
                ->assertStatus(200)
                ->assertExactJson([
                    'result'=> 'success',
                ]);
    }

    public function testGetHelpTopics()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/help-topic?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'topic',
                ]);
    }

    public function testGetSla()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/sla-plan?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'name',
                ]);
    }

    public function testGetPriority()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/priority?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'priority',
                ]);
    }

    public function testGetDepartment()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/department?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'name',
                ]);
    }

    public function testGetAllTickets()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/tickets?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'current_page',
                ]);
    }

    public function testGetInbox()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/inbox?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'current_page',
                ]);
    }

    public function testGetTrash()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/trash?token='.$token);
        $response = $this->json('GET', $url);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'current_page',
                ]);
    }

    public function testPostInternalNote()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/internal-note?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('post', $url, [
            'ticketid'=> $ticket->id,
            'userid'  => $user->id,
            'body'    => 'This is an internal note',
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'thread',
                ]);
    }

    public function testGetTicketByAgent()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $agent = \App\User::where('role', '!=', 'user')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/my-tickets-agent?token='.$token);
        $response = $this->json('GET', $url, ['user_id'=>$agent->id]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'current_page',
                ]);
    }

    public function testGetTicketByUser()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $agent = \App\User::where('role', '=', 'user')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/my-tickets-user?token='.$token);
        $response = $this->json('GET', $url, ['user_id'=>$agent->id]);
        $response
                ->assertStatus(200)
                ->assertJsonMissing([
                    'error',
                ]);
    }

    public function testPostCollaborator()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/create?token='.$token);
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
            'email'    => $this->userMake()->email,
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonMissing([
                    'error',
                ]);
    }

    public function testGetCollaboratorBySearch()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/collaborator/search?token='.$token);
        $response = $this->json('GET', $url, ['term'=>'s']);
        $response
                ->assertStatus(200)
                ->assertJsonMissing([
                    'error',
                ])
                ->assertJsonFragment([
                    'users',
                ]);
    }

    public function testGetCollaboratorWithTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/get-ticket?token='.$token);
        $response = $this->json('POST', $url, ['ticket_id'=>$ticket->id]);
        $response
                ->assertStatus(200)
                ->assertJsonMissing([
                    'error',
                ])
                ->assertJsonFragment([
                    'collaborator',
                ]);
    }

    public function testRemoveCollaboratorFromTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/remove?token='.$token);
        $response = $this->json('POST', $url, [
            'ticketid'=> $ticket->id,
            'email'   => 'test@example.com',
            ]);
        $response
                //->assertStatus(200)
                ->assertJsonMissing([
                    'error',
                ])
                ->assertJsonFragment([
                    'collaborator',
                ]);
    }

//    public function testGetTicketWithFilters(){
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
