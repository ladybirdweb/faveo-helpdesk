<?php

use Illuminate\Database\Seeder;
use App\Model\Common\TemplateSet;
use App\Model\Common\TemplateType;
use App\Model\Common\Template;

class TemplateSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TemplateSet::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        TemplateSet::create(['id' => '1', 'name' => 'default', 'active' => '1']);
        TemplateType::truncate();
        TemplateType::create(['id' => '1', 'name' => 'assign-ticket']);
        TemplateType::create(['id' => '2', 'name' => 'check-ticket']);
        TemplateType::create(['id' => '3', 'name' => 'close-ticket']);
        TemplateType::create(['id' => '4', 'name' => 'create-ticket']);
        TemplateType::create(['id' => '5', 'name' => 'create-ticket-agent']);
        TemplateType::create(['id' => '6', 'name' => 'create-ticket-by-agent']);
        TemplateType::create(['id' => '7', 'name' => 'registration-notification']);
        TemplateType::create(['id' => '8', 'name' => 'reset-password']);
        TemplateType::create(['id' => '9', 'name' => 'ticket-reply']);
        TemplateType::create(['id' => '10', 'name' => 'ticket-reply-agent']);
        TemplateType::create(['id' => '11', 'name' => 'registration']);
        TemplateType::create(['id' => '12', 'name' => 'due_violate']);
        TemplateType::create(['id' => '13', 'name' => 'team_assign_ticket']);
        TemplateType::create(['id' => '14', 'name' => 'reset_new_password']);
        TemplateType::create(['id' => '15', 'name' => 'internal_change']);
        TemplateType::create(['id' => '16', 'name' => 'due_approach']);
        TemplateType::create(['id' => '17', 'name' => 'new-user']);

        Template::truncate();
        Template::create(['id' => '1', 'variable' => '0', 'name' => 'This template is for sending notice to agent when ticket is assigned to them', 'type' => '1', 
            'message' => '<div>Hello {!!$ticket_agent_name!!},<br/><br/>'
            . '<b>Ticket No:</b> {!!$ticket_number!!}<br/>'
            . 'Has been assigned to you by {!!$ticket_assigner!!} <br/>'
            . '<br/>Thank You<br/>Kind Regards,<br/> {!!$system_from!!}</div>', 
            'set_id' => '1']);
        Template::create(['id' => '2', 'variable' => '1', 'name' => 'This template is for sending notice to client with ticket link to check ticket without logging in to system', 'type' => '2', 'subject' => 'Check your Ticket', 'message' => '<div>Hello {!!$user!!},<br/><br/>Click the link below to view your requested ticket<br/> {!!$ticket_link_with_number!!}<br/><br/>Kind Regards,<br/> {!!$system_from!!}</div>', 'set_id' => '1']);
        Template::create(['id' => '3', 'variable' => '0', 'name' => 'This template is for sending notice to client when ticket status is changed to close', 'type' => '3', 'message' => '<div>Hello,<br/><br/>This message is regarding your ticket ID {!!$ticket_number!!}. We are changing the status of this ticket to "Closed" as the issue appears to be resolved.<br/><br/>Thank you<br/>Kind regards,<br/> {!!$system_from!!}</div>', 'set_id' => '1']);
        Template::create(['id' => '4', 'variable' => '0', 'name' => 'This template is for sending notice to client on successful ticket creation', 'type' => '4', 'message' => '<div><span>Hello {!!$user!!}<br/><br/></span><span>Thank you for contacting us. This is an automated response confirming the receipt of your ticket. Our team will get back to you as soon as possible. When replying, please make sure that the ticket ID is kept in the subject so that we can track your replies.<br/><br/></span><span><b>Ticket ID:</b> {!!$ticket_number!!} <br/><br/></span><span> {!!$department_sign!!}<br/></span>You can check the status of or update this ticket online at: {!!$system_link!!}</div>', 'set_id' => '1']);
        Template::create(['id' => '5', 'variable' => '0', 'name' => 'This template is for sending notice to agent on new ticket creation', 'type' => '5', 'message' => '<div>Hello {!!$ticket_agent_name!!},<br/><br/>New ticket {!!$ticket_number!!}created <br/><br/><b>From</b><br/><b>Name:</b> {!!$ticket_client_name!!}   <br/><b>E-mail:</b> {!!$ticket_client_email!!}<br/><br/> {!!$content!!}<br/><br/>Kind Regards,<br/> {!!$system_from!!}</div>', 'set_id' => '1']);
        Template::create(['id' => '6', 'variable' => '0', 'name' => 'This template is for sending notice to client on new ticket created by agent in name of client', 'type' => '6', 'message' => '<div> {!!$content!!}<br><br> {!!$agent_sign!!}<br><br>You can check the status of or update this ticket online at: {!!$system_link!!}</div>', 'set_id' => '1']);
        Template::create(['id' => '7', 'variable' => '1', 'name' => 'This template is for sending notice to client on new registration during new ticket creation for un registered clients', 'type' => '7', 'subject' => 'Registration Confirmation', 'message' => '<p>Hello {!!$user!!}, </p><p>This email is confirmation that you are now registered at our helpdesk.</p><p><b>Registered Email:</b> {!!$email_address!!}</p><p><b>Password:</b> {!!$user_password!!}</p><p>You can visit the helpdesk to browse articles and contact us at any time: {!!$system_link!!}</p><p>Thank You.</p><p>Kind Regards,</p><p> {!!$system_from!!} </p>', 'set_id' => '1']);
        Template::create(['id' => '8', 'variable' => '1', 'name' => 'This template is for sending notice to any user about reset password option', 'type' => '8', 'subject' => 'Reset your Password', 'message' => 'Hello {!!$user!!},<br/><br/>You asked to reset your password. To do so, please click this link:<br/><br/> {!!$password_reset_link!!}<br/><br/>This will let you change your password to something new.' . " If you didn't ask for this, don't worry, we'll keep your password safe.<br/><br/>Thank You.<br/><br/>Kind Regards,<br/>" . ' {!!$system_from!!}', 'set_id' => '1']);
        Template::create([
            'id' => '9',
            'variable' => '0',
            'name' => 'This template is for sending notice to client when a reply made to his/her ticket',
            'type' => '9',
            'message' => '<span></span><div><span></span><p> {!!$content!!}<br/></p>'
            . '<p> {!!$agent_sign!!} </p>'
            . '<p><b>Ticket Details</b></p>'
            . '<p><b>Ticket ID:</b> {!!$ticket_number!!}</p></div>',
            'set_id' => '1'
        ]);
        Template::create(['id' => '10', 'variable' => '0', 'name' => 'This template is for sending notice to agent when ticket reply is made by client on a ticket', 'type' => '10', 'message' => '<div>Hello {!!$ticket_agent_name!!},<br/><b><br/></b>A reply been made to ticket {!!$ticket_number!!}<br/><b><br/></b><b>From<br/></b><b>Name: </b>{!!$ticket_client_name!!}<br/><b>E-mail: </b>{!!$ticket_client_email!!}<br/><b><br/></b> {!!$content!!}<br/><b><br/></b>Kind Regards,<br/> {!!$system_from!!}</div>', 'set_id' => '1']);
        Template::create([
            'id' => '11',
            'variable' => '1',
            'name' => 'This template is for sending notice to client about registration confirmation link',
            'type' => '11',
            'subject' => 'Verify your email address',
            'message' => '<p>Hello {!!$user!!}, '
            . '</p><p>This email is confirmation that you are now registered at our helpdesk.</p>'
            . '<p><b>Registered Email:</b> {!!$email_address!!}</p>'
            . '<p>Please click on the below link to activate your account and Login to the system {!!$password_reset_link!!}</p>'
            . '<p>Thank You.</p><p>Kind Regards,</p><p> {!!$system_from!!} </p>',
            'set_id' => '1'
        ]);
        Template::create([
            'id' => '12',
            'variable' => '1',
            'name' => 'This template is for sending escalate notice to agents',
            'type' => '12',
            'subject' => 'SLA Violate',
            'message' => 'Hello {!!$user!!},<br/>'
            . '</p><p>There has been no response for a ticket. Ticket was due by  {!!$duedate!!}.</p><br>'
            . '<p><strong>Ticket Details: </p>'
            . '<p><strong>Subject: </strong>{!!$title!!} </p>'
            . '<p><strong>Number: </strong>{!!$ticket_number!!} </p>'
            . '<p><strong>Requester: </strong>{!!$requester!!} </p><br/>'
            . '<p>This is an automatic escalation email from {!!$system_from!!}  </p><br/>'
            .'<p>Respond to ticket here {!!$ticket_link_with_number!!}  </p>'
            . '<p>Thank You.</p><p>Kind Regards,</p><p> {!!$system_from!!} </p>',
            'set_id' => '1'
        ]);
        
        Template::create([
            'id' => '13',
            'variable' => '1',
            'name' => 'This template is for sending notice to team when ticket is assigned to team',
            'type' => '13',
            'subject' => '',
            'message' => '<div>
             Hello {!!$ticket_agent_name!!}<br /><br /><b>Ticket No:</b> {!!$ticket_number!!}<br />Has been assigned to your team  by {!!$ticket_assigner!!} <br />Please check and resppond on the ticket.<br />Link: {!!$ticket_link!!}<br /><br />Thank You<br />Kind Regards,<br />{!!$system_from!!}</div>',
            'set_id' => '1'
        ]);
        Template::create([
            'id' => '14',
            'variable' => '1',
            'name' => 'This template is for sending notice to client when password is changed',
            'type' => '14',
            'subject' => 'Password changed',
            'message' => 'Hello {!!$user!!},<br /><br />Your password is successfully changed.Your new password is : {!!$user_password!!}<br /><br />Thank You.<br /><br />Kind Regards,<br /> {!!$system_from!!}',
            'set_id' => '1'
        ]);
        
         Template::create([
            'id' => '15',
            'variable' => '1',
            'name' => 'This template is for sending notice when ticket elements is changed',
            'type' => '15',
            'subject' => '',
            'message' => '<div>Hello {!!$ticket_agent_name!!},<br/><br/>This message is regarding your ticket ID {!!$ticket_number!!}.<br>{!!$internal_content!!}.<br>By {!!$by!!}<br/><br/>Thank you<br/>Kind regards,<br/> {!!$system_from!!}</div>',
            'set_id' => '1'
        ]);
         
        Template::create([
            'id' => '16',
            'variable' => '1',
            'name' => 'This template is for sending response escalate notice for approach conditions',
            'type' => '16',
            'subject' => 'SLA Approaching',
            'message' => 'Hello {!!$user!!},<br/>'
            . '</p><p>There has been no response for a ticket. Resolve should happen on or before {!!$duedate!!}.</p><br>'
            . '<p><strong>Ticket Details: </p>'
            . '<p><strong>Subject: </strong>{!!$title!!} </p>'
            . '<p><strong>Number: </strong>{!!$ticket_number!!} </p>'
            . '<p><strong>Requester: </strong>{!!$requester!!} </p><br/>'
            . '<p>This is an automatic escalation email from {!!$system_from!!}  </p><br/>'
            .'<p>Respond to ticket here {!!$ticket_link_with_number!!}  </p><br>'
            . '<p>Thank You.</p><p>Kind Regards,</p><p> {!!$system_from!!} </p>',
            'set_id' => '1'
        ]);
        
       
        
        Template::create([
            'id' => '17',
            'variable' => '1',
            'name' => 'This template is for sending notification for a new user entry',
            'type' => '17',
            'subject' => 'New user has created',
            'message' => '<p>Hello {!!$user!!}, '
            . '</p><p>This email is notifying you that a new user has entred in our helpdesk.</p>'
            . '<p><b>Registered User Name:</b> {!!$email_address!!}</p>'
            . '<p>Please click on the below link to see the profile {!!$user_profile_link!!}</p>'
            . '<p>Thank You.</p><p>Kind Regards,</p><p> {!!$system_from!!} </p>',
            'set_id' => '1'
        ]);
    }

}
