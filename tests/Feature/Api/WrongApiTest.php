<?php

namespace Tests\Feature\Api;

use TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WrongApiTest extends TestCase
{
    public function userCreate() {
        $user = factory(\App\User::class)->create();
        return $user;
    }
    
    public function userMake() {
        $user = factory(\App\User::class)->make();
        return $user;
    }
    
    public function authenticate(\App\User $user) {
        return \JWTAuth::setToken(\JWTAuth::fromUser($user));
    }
    
    public function testWrongUserNameAuthenticate() {
        $url = url('api/v1/authenticate');
        $user = $this->userMake();
        $response = $this->json('POST', $url, [
            'username' => $user->user_name,
            'password' => 'secret',
        ]);
        $response
                //->assertStatus(200)
                ->assertJsonFragment([
                    'status_code'=>401,
                ])
        ;
    }
    
    public function testWrongPasswordAuthenticate() {
        $url = url('api/v1/authenticate');
        $user = $this->userMake();
        $response = $this->json('POST', $url, [
            'username' => $user->user_name,
            'password' => 's',
        ]);
        $response
                ->assertJsonFragment([
                    'status_code'=>401,
                ])
        ;
    }
    
    
    
    public function testWrongUserTicketCreate() {
        $url = url('/api/v1/helpdesk/create');
        $user = \App\User::orderBy('id','desc')->first();
        $this->authenticate($user);
        $response = $this->call('POST', $url, [
            'user_id'=>10000,
            'body'=>'Testing the unit cases',
            'email'=>$user->email,
            'first_name'=>$user->first_name,
            'helptopic'=>1,
            'priority'=>1,
            'sla'=>1,
            'subject'=>'Testin Unit Cases',
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'user_id',
                ])
        ;
    }
    
//    public function testWrongEmailTicketCreate() {
//        $url = url('/api/v1/helpdesk/create');
//        $user = \App\User::orderBy('id','desc')->first();
//        $this->authenticate($user);
//        $response = $this->call('POST', $url, [
//            'user_id'=>$user->id,
//            'body'=>'Testing the unit cases',
//            'email'=>'css',
//            'first_name'=>$user->first_name,
//            'helptopic'=>1,
//            'priority'=>1,
//            'sla'=>1,
//            'subject'=>'Testin Unit Cases',
//        ]);
//        $response
//                ->assertStatus(200)
//                ->assertJsonFragment([
//                    'email',
//                ])
//        ;
//    }
    
    
    
    
//    public function testWrongHelpTopicTicketCreate() {
//        $url = url('/api/v1/helpdesk/create');
//        $user = \App\User::orderBy('id','desc')->first();
//        $this->authenticate($user);
//        $response = $this->call('POST', $url, [
//            'user_id'=>$user->id,
//            'body'=>'Testing the unit cases',
//            'email'=>$user->email,
//            'first_name'=>$user->first_name,
//            'helptopic'=>1000,
//            'priority'=>1,
//            'sla'=>1,
//            'subject'=>'Testin Unit Cases',
//        ]);
//        $response
//                ->assertStatus(200)
//                ->assertJsonFragment([
//                    'helptopic',
//                ])
//        ;
//    }
    
    
    public function testWrongSubjectTicketCreate() {
        $url = url('/api/v1/helpdesk/create');
        $user = \App\User::orderBy('id','desc')->first();
        $this->authenticate($user);
        $response = $this->call('POST', $url, [
            'user_id'=>$user->id,
            'body'=>'Testing the unit cases',
            'email'=>$user->email,
            'first_name'=>$user->first_name,
            'helptopic'=>1,
            'priority'=>1,
            'sla'=>1,
            'subject'=>'',
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'subject',
                ])
        ;
    }
    
    
//    public function testWrongUserNameRegister(){
//        $url = url('/api/v1/register');
//        $user = factory(\App\User::class)->make();
//        $response = $this->call('POST', $url, [
//            'username'=>'12345',
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
    
    public function testWrongEmailRegister(){
        $url = url('/api/v1/register');
        $user = factory(\App\User::class)->make();
        $response = $this->call('POST', $url, [
            'username'=>$user->user_name,
            'email'=>'dscd',
            'password'=>'secrete',
            'first_name'=>$user->first_name,
            'last_name'=>$user->first_name,
            
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'email',
                ])
        ;
    }
    
    public function testWrongPasswordRegister(){
        $url = url('/api/v1/register');
        $user = factory(\App\User::class)->make();
        $response = $this->call('POST', $url, [
            'username'=>$user->user_name,
            'email'=>$user->email,
            'password'=>'s',
            'first_name'=>$user->first_name,
            'last_name'=>$user->first_name,
            
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'password',
                ])
        ;
    }
    
//    public function testWrongFirstNameRegister(){
//        $url = url('/api/v1/register');
//        $user = factory(\App\User::class)->make();
//        $response = $this->call('POST', $url, [
//            'username'=>$user->user_name,
//            'email'=>$user->email,
//            'password'=>'secrete',
//            'first_name'=>'',
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
    
//    public function testWrongLastNameRegister(){
//        $url = url('/api/v1/register');
//        $user = factory(\App\User::class)->make();
//        $response = $this->call('POST', $url, [
//            'username'=>$user->user_name,
//            'email'=>$user->email,
//            'password'=>'secrete',
//            'first_name'=>$user->first_name,
//            'last_name'=>'',
//            
//        ]);
//        $response
//                ->assertStatus(200)
//                ->assertJsonFragment([
//                    'last_name',
//                ])
//        ;
//    }
    
    public function testWrongUrl(){
        $url = url('api/v1/helpdesk/url');
        $response = $this->json('GET', $url, [
            'url'=>  'dscjhsd'
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'url',
                ])
        ;
    }
    
    public function testWrongTicketIdReply(){
        $url = url('api/v1/helpdesk/reply');
        $user = \App\User::orderBy('id','desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_ID'=> 10000000,
            'reply_content'=> 'Replied'
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_ID',
                ])
        ;
    }
    
    public function testWrongContentReply(){
        $url = url('api/v1/helpdesk/reply');
        $user = \App\User::orderBy('id','desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_ID'=> $ticket->id,
            'reply_content'=> ''
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'reply_content',
                ])
        ;
    }
    
    public function testWrongTicketIdEditTicket(){
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id','desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> 10000,
            'subject'=> 'New Title',
            'help_topic'=>$ticket->help_topic_id,
            'ticket_type'=>$ticket->type,
            'ticket_source'=>$ticket->source,
            'ticket_priority'=>1,
            'sla_plan'=>$ticket->sla
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_id',
                ])
        ;
    }
    
    public function testWrongSubjectEditTicket(){
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id','desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
            'subject'=> '',
            'help_topic'=>$ticket->help_topic_id,
            'ticket_type'=>$ticket->type,
            'ticket_source'=>$ticket->source,
            'ticket_priority'=>1,
            'sla_plan'=>$ticket->sla
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'subject',
                ])
        ;
    }
    
    public function testWrongHelpTopicEditTicket(){
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id','desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
            'subject'=> 'New Title',
            'help_topic'=>100000,
            'ticket_type'=>$ticket->type,
            'ticket_source'=>$ticket->source,
            'ticket_priority'=>1,
            'sla_plan'=>$ticket->sla
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'help_topic',
                ])
        ;
    }
    
//    public function testWrongTypeEditTicket(){
//        $url = url('api/v1/helpdesk/edit');
//        $user = \App\User::orderBy('id','desc')->first();
//        $this->authenticate($user);
//        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
//        $response = $this->json('POST', $url, [
//            'ticket_id'=> $ticket->id,
//            'subject'=> 'New Title',
//            'help_topic'=>$ticket->help_topic_id,
//            'ticket_type'=>100000,
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
    
    public function testWrongSourceEditTicket(){
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id','desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
            'subject'=> 'New Title',
            'help_topic'=>$ticket->help_topic_id,
            'ticket_type'=>$ticket->type,
            'ticket_source'=>10000,
            'ticket_priority'=>1,
            'sla_plan'=>$ticket->sla
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_source',
                ])
        ;
    }
    
    public function testWrongPriorityEditTicket(){
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id','desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
            'subject'=> 'New Title',
            'help_topic'=>$ticket->help_topic_id,
            'ticket_type'=>$ticket->type,
            'ticket_source'=>$ticket->source,
            'ticket_priority'=>100000,
            'sla_plan'=>$ticket->sla
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_priority',
                ])
        ;
    }
    
    public function testWrongSlaEditTicket(){
        $url = url('api/v1/helpdesk/edit');
        $user = \App\User::orderBy('id','desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
            'subject'=> 'New Title',
            'help_topic'=>$ticket->help_topic_id,
            'ticket_type'=>$ticket->type,
            'ticket_source'=>$ticket->source,
            'ticket_priority'=>1,
            'sla_plan'=>10000
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'sla_plan',
                ])
        ;
    }
    
    public function testWrongTicketIdDeleteTicket(){
        $url = url('api/v1/helpdesk/delete');
        $user = \App\User::orderBy('id','desc')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> 1000000,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_id',
                ])
        ;
    }
    
    public function testWrongUserIdGetCustomerById(){
        $user = \App\User::orderBy('id','desc')->first();
        $client = \App\User::where('role','user')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/customer?token='.$token);
        $response = $this->json('GET', $url,[
            'user_id'=>10000
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'user_id',
                ])
        ;
    }
    
    public function testWrongTicketIdGetThreadByTicketId(){
        $user = \App\User::orderBy('id','desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/ticket-thread?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('GET', $url, [
            'id'=> 10000,
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'id',
                ])
        ;
    }
    
    public function testWrongTicketIdTicketAssign(){
        $url = url('api/v1/helpdesk/assign');
        $user = \App\User::orderBy('id','desc')->first();
        $agent = \App\User::where('role','!=','user')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> 10000,
            'user'=>$agent->id
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_id',
                ])
        ;
    }
    
    public function testWrongUserTicketAssign(){
        $url = url('api/v1/helpdesk/assign');
        $user = \App\User::orderBy('id','desc')->first();
        $agent = \App\User::where('role','!=','user')->first();
        $this->authenticate($user);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('POST', $url, [
            'ticket_id'=> $ticket->id,
            'user'=>10000
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'user',
                ])
        ;
    }
    
    public function testWrongTicketIdPostInternalNote(){
        $user = \App\User::orderBy('id','desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/internal-note?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('post', $url,[
            'ticketid'=>10000,
            'userid'=>$user->id,
            'body'=>'This is an internal note',
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticketid',
                ])
        ;
    }
    
    public function testWrongUserIdPostInternalNote(){
        $user = \App\User::orderBy('id','desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/internal-note?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('post', $url,[
            'ticketid'=>$ticket->id,
            'userid'=>100000,
            'body'=>'This is an internal note',
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'userid',
                ])
        ;
    }
    
    public function testWrongBodyPostInternalNote(){
        $user = \App\User::orderBy('id','desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/internal-note?token='.$token);
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $response = $this->json('post', $url,[
            'ticketid'=>$ticket->id,
            'userid'=>$user->id,
            'body'=>'',
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'body',
                ])
        ;
    }
    
    public function testWrongTicketIdPostCollaborator(){
        $user = \App\User::orderBy('id','desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/create?token='.$token);
        $response = $this->json('POST', $url,[
            'ticket_id'=>10000,
            'email'=>  $this->userMake()->email,
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'ticket_id',
                ])
        ;
    }
    
    public function testWrongEmailPostCollaborator(){
        $user = \App\User::orderBy('id','desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/create?token='.$token);
        $response = $this->json('POST', $url,[
            'ticket_id'=>$ticket->id,
            'email'=>  's',
        ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'email',
                ])
        ;
    }
    
    public function testWrongTermGetCollaboratorBySearch(){
        $user = \App\User::orderBy('id','desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $url = url('api/v1/helpdesk/collaborator/search?token='.$token);
        $response = $this->json('GET', $url,['term'=>'']);
        $response
                ->assertStatus(200)
                
                ->assertJsonFragment([
                    'term',
                ])
        ;
    }
    
    public function testWrongTicketIdGetCollaboratorWithTicket(){
        $user = \App\User::orderBy('id','desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/get-ticket?token='.$token);
        $response = $this->json('POST', $url,['ticket_id'=>100000]);
        $response
                ->assertStatus(200)
                
                ->assertExactJson([
                    'collaborator'=>[],
                ])
        ;
    }
    
    public function testWrongTicketIdRemoveCollaboratorFromTicket(){
        $user = \App\User::orderBy('id','desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/remove?token='.$token);
        $response = $this->json('POST', $url,[
            'ticketid'=>100000,
            'email'=>'test@example.com'
            ]);
        $response
                //->assertStatus(200)
                
                ->assertJsonFragment([
                    'ticketid',
                ])
        ;
    }
    
    public function testWrongEmailRemoveCollaboratorFromTicket(){
        $user = \App\User::orderBy('id','desc')->first();
        $auth = $this->authenticate($user);
        $token = $auth->getToken()->get();
        $ticket = \App\Model\helpdesk\Ticket\Tickets::first();
        $url = url('api/v1/helpdesk/collaborator/remove?token='.$token);
        $response = $this->json('POST', $url,[
            'ticketid'=>$ticket->id,
            'email'=>'test'
            ]);
        $response
                ->assertStatus(200)
                ->assertJsonFragment([
                    'email',
                ])
        ;
    }
    
    
    
    
    
}
