<?php

namespace Tests\Feature\Api;

use TestCase;

class InvalidApiTest extends TestCase
{
    public function userCreate()
    {
        $user = factory(\App\User::class)->create();

        return $user;
    }

    public function userMake()
    {
        $user = factory(\App\User::class)->make();

        return $user;
    }

    public function authenticate(\App\User $user)
    {
        return \JWTAuth::setToken(\JWTAuth::fromUser($user));
    }

    public function testInvalidUserAuthenticate()
    {
        $url = url('api/v1/authenticate');
        $user = $this->userMake();
        $response = $this->json('POST', $url, [
            'password' => 'secret',
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'error'=> 'invalid_credentials',
                ]);
    }

    public function testInvalidPasswordAuthenticate()
    {
        $url = url('api/v1/authenticate');
        $user = $this->userMake();
        $response = $this->json('POST', $url, [
            'username' => $user->user_name,
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'error'=> 'invalid_credentials',
                ]);
    }

    public function testInvalidCreate()
    {
        $url = url('/api/v1/helpdesk/create');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $response = $this->call('POST', $url, [

        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'error',
                ]);
    }

    public function testInvalidUserTicketCreate()
    {
        $url = url('/api/v1/helpdesk/create');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $response = $this->call('POST', $url, [

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
                    'user_id',
                ]);
    }

    public function testInvalidBodyTicketCreate()
    {
        $url = url('/api/v1/helpdesk/create');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $response = $this->call('POST', $url, [

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
                    'body',
                ]);
    }

    public function testInvalidHelpTopicTicketCreate()
    {
        $url = url('/api/v1/helpdesk/create');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $response = $this->call('POST', $url, [
            'priority'=> 1,
            'sla'     => 1,
            'subject' => 'Testin Unit Cases',
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'helptopic',
                ]);
    }

    public function testInvalidSubjectTicketCreate()
    {
        $url = url('/api/v1/helpdesk/create');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $response = $this->call('POST', $url, [
            'sla'=> 1,
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'subject',
                ]);
    }

//    public function testInvalidUserNameRegister(){
//        $url = url('/api/v1/register');
//        $user = factory(\App\User::class)->make();
//        $response = $this->call('POST', $url, [
//            'email'=>$user->email,
//            'password'=>'secrete',
//            'first_name'=>$user->first_name,
//            'last_name'=>$user->first_name,
//
//        ]);
//        $response
//                ->assertStatus(200)
//                ->assertJsonFragment([
//                    'username',
//                ])
//        ;
//    }

    public function testInvalidEmailRegister()
    {
        $url = url('/api/v1/register');
        $user = factory(\App\User::class)->make();
        $response = $this->call('POST', $url, [
            'username'  => $user->user_name,
            'password'  => 'secrete',
            'first_name'=> $user->first_name,
            'last_name' => $user->first_name,

        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'email',
                ]);
    }

    public function testInvalidPasswordRegister()
    {
        $url = url('/api/v1/register');
        $user = factory(\App\User::class)->make();
        $response = $this->call('POST', $url, [
            'username'  => $user->user_name,
            'email'     => $user->email,
            'first_name'=> $user->first_name,
            'last_name' => $user->first_name,

        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'password',
                ]);
    }

//    public function testInvalidFirstNameRegister(){
//        $url = url('/api/v1/register');
//        $user = factory(\App\User::class)->make();
//        $response = $this->call('POST', $url, [
//            'username'=>$user->user_name,
//            'email'=>$user->email,
//            'password'=>'secrete',
//            'last_name'=>$user->first_name,
//
//        ]);
//        $response
//                ->assertStatus(200)
//                ->assertJsonFragment([
//                    'first_name',
//                ])
//        ;
//    }

//    public function testInvalidLastNameRegister(){
//        $url = url('/api/v1/register');
//        $user = factory(\App\User::class)->make();
//        $response = $this->call('POST', $url, [
//            'username'=>$user->user_name,
//            'email'=>$user->email,
//            'password'=>'secrete',
//            'first_name'=>$user->first_name,
//
//        ]);
//        $response
//                ->assertStatus(200)
//                ->assertJsonFragment([
//                    'last_name',
//                ])
//        ;
//    }

    public function testInvalidUrl()
    {
        $url = url('api/v1/helpdesk/url');
        $response = $this->json('GET', $url, [
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'url',
                ]);
    }

    public function testInvalidTicketIdReply()
    {
        $url = url('api/v1/helpdesk/reply');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'reply_content'=> 'Replied',
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_ID',
                ]);
    }

    public function testInvalidContentReply()
    {
        $url = url('api/v1/helpdesk/reply');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_ID'=> $ticket->id,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'reply_content',
                ]);
    }

    public function testInvalidTicketIdEditTicket()
    {
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
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
                    'ticket_id',
                ]);
    }

    public function testInvalidSubjectEditTicket()
    {
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'      => $ticket->id,
            'help_topic'     => $ticket->help_topic_id,
            'ticket_type'    => $ticket->type,
            'ticket_source'  => $ticket->source,
            'ticket_priority'=> 1,
            'sla_plan'       => $ticket->sla,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'subject',
                ]);
    }

    public function testInvalidHelpTopicEditTicket()
    {
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'      => $ticket->id,
            'subject'        => 'New Title',
            'ticket_type'    => $ticket->type,
            'ticket_source'  => $ticket->source,
            'ticket_priority'=> 1,
            'sla_plan'       => $ticket->sla,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'help_topic',
                ]);
    }

//    public function testInvalidTypeEditTicket(){
//        $url = url('api/v1/helpdesk/edit');
//        $user = \App\User::orderBy('id','desc')->first();
//        $this->authenticate($user);
//        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
//        $response = $this->json('POST', $url, [
//            'ticket_id'=> $ticket->id,
//            'subject'=> 'New Title',
//            'help_topic'=>$ticket->help_topic_id,
//            'ticket_source'=>$ticket->source,
//            'ticket_priority'=>1,
//            'sla_plan'=>$ticket->sla
//            ]);
//        $response
//                ->assertStatus(200)
//                ->assertJsonFragment([
//                    'ticket_type',
//                ])
//        ;
//    }

    public function testInvalidSourceEditTicket()
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
            'ticket_priority'=> 1,
            'sla_plan'       => $ticket->sla,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_source',
                ]);
    }

    public function testInvalidPriorityEditTicket()
    {
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'    => $ticket->id,
            'subject'      => 'New Title',
            'help_topic'   => $ticket->help_topic_id,
            'ticket_type'  => $ticket->type,
            'ticket_source'=> $ticket->source,
            'sla_plan'     => $ticket->sla,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_priority',
                ]);
    }

    public function testInvalidSlaEditTicket()
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
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'sla_plan',
                ]);
    }

    public function testInvalidTicketIdDeleteTicket()
    {
        $url = url('api/v1/helpdesk/delete');
        $user = \App\User::orderBy('id', 'desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_id',
                ]);
    }

    public function testInvalidUserIdGetCustomerById()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $client = \App\User::where('role', 'user')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/customer?token='.$token);
        $response = $this->json('GET', $url, [

        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'user_id',
                ]);
    }

    public function testInvalidTicketIdGetThreadByTicketId()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/ticket-thread?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('GET', $url, [

            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'id',
                ]);
    }

    public function testInvalidTicketIdTicketAssign()
    {
        $url = url('api/v1/helpdesk/assign');
        $user = \App\User::orderBy('id', 'desc')->first();
        $agent = \App\User::where('role', '!=', 'user')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'user'=> $agent->id,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_id',
                ]);
    }

    public function testInvalidUserTicketAssign()
    {
        $url = url('api/v1/helpdesk/assign');
        $user = \App\User::orderBy('id', 'desc')->first();
        $agent = \App\User::where('role', '!=', 'user')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'user',
                ]);
    }

    public function testInvalidTicketIdPostInternalNote()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/internal-note?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('post', $url, [

            'userid'=> $user->id,
            'body'  => 'This is an internal note',
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticketid',
                ]);
    }

    public function testInvalidUserIdPostInternalNote()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/internal-note?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('post', $url, [
            'ticketid'=> $ticket->id,

            'body'=> 'This is an internal note',
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'userid',
                ]);
    }

    public function testInvalidBodyPostInternalNote()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/internal-note?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('post', $url, [
            'ticketid'=> $ticket->id,
            'userid'  => $user->id,

            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'body',
                ]);
    }

    public function testInvalidTicketIdPostCollaborator()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/create?token='.$token);
        $response = $this->json('POST', $url, [
            'email'=> $this->userMake()->email,
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_id',
                ]);
    }

    public function testInvalidEmailPostCollaborator()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/create?token='.$token);
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'email',
                ]);
    }

    public function testInvalidTermGetCollaboratorBySearch()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/collaborator/search?token='.$token);
        $response = $this->json('GET', $url, []);
        $response
                //->assertStatus(200)

                ->assertJsonFragment([
                    'term',
                ]);
    }

    public function testInvalidTicketIdGetCollaboratorWithTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/get-ticket?token='.$token);
        $response = $this->json('POST', $url, []);
        $response
                ->assertStatus(200)

                ->assertJsonFragment([
                    'ticket_id',
                ]);
    }

    public function testInvalidTicketIdRemoveCollaboratorFromTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/remove?token='.$token);
        $response = $this->json('POST', $url, [

            'email'=> 'test@test@example.com',
            ]);
        $response
                ->assertStatus(200)

                ->assertJsonFragment([
                    'ticketid',
                ]);
    }

    public function testInvalidEmailRemoveCollaboratorFromTicket()
    {
        $user = \App\User::orderBy('id', 'desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/remove?token='.$token);
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'email',
                ]);
    }
}
