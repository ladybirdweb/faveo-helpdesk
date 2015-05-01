
<?php
return array(

 /*
      |----------------------------------------------------------------------------------------
      | Authentication Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all authentication related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */


    /*
      |--------------------------------------
      |   Login Page
      |--------------------------------------
     */

    'signin' 				=> 'Sign In',
    'remember' 				=> 'Remember Me',
    'signmein' 				=> 'Sign me In',
    'iforgot' 				=> 'I forgot my Password',
    'email_address' 		=> 'E-Mail Address',
    'password'				=>	'password',
    'woops' 				=>	'Whoops!',
    'theirisproblem'		=> 	'There were some problems with your input.',
    'login'					=>	'Login',
    /*
      |--------------------------------------
      |   Forgot Password Page
      |--------------------------------------
     */

    'recover_passord' 			=> 'Recover Password',
    'send_password_reset_link' 	=> 'Send pasword Reset Link',

    /*
      |----------------------------------------------------------------------------------------
      | Staff Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Staff related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */

      /*
      |--------------------------------------
      |   Staff index Page
      |--------------------------------------
     */


		'name'			=>'Name',	
		'user_name'		=>'User Name',	
		'status'		=>'Status',	
		'group'			=>'Group',	
		'department'	=>'Department',	
		'created'		=>'Created',	
		'lastlogin'		=>'Last Login',
		'createagent'	=>'Create An Agent',
		'delete'		=>'Delete',
		'agents'		=>'Agents',
		'create'		=>'Create',
		'edit'			=>'Edit',

	/*
      |----------------------------------------------------------------------------------------
      | Settings Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Setting related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */

      /*
      |--------------------------------------
      |   Company Settings Page
      |--------------------------------------
     */

      	'company'		=>'Company',
	    'website'		=>'Website', 
		'phone'			=>'Phone', 
		'address'		=>'Address', 
		'landing'		=>'landing Page', 
		'offline'		=>'offline Page', 
		'thank'			=>'Thank Page', 
		'logo'			=>'Logo',
		'save'			=>'Save',

	/*
      |--------------------------------------
      |   System Settings Page
      |--------------------------------------
     */

      	'system'		=>'System',
		'online'		=>'Online',	
		'offline'		=>'Offline',
		'name/title'	=>'Name/Title',
		'pagesize'		=>'Page Size',
		'url'			=>'URL',
		'default_department'=>'Default Department',
		'loglevel'		=>'Log Level',	   
		'purglog'		=>'Purge Logs',	 
		'nameformat'	=>'Name Formatting',
		'timeformat'	=>'Time Format',
		'dateformat'	=>'Date Format',
		'date_time'		=>'Date And Time Format',
		'day_date_time'	=>'Day,Date And Time Format',
		'timezone'		=>'Default Time Zone',

      /*
      |--------------------------------------
      |   Email Settings Page
      |--------------------------------------
     */

		'email'								=>'Email',
		'default_template'					=>'Default Template Set:',
		'default_system_email'				=>'Default System Email:',
		'default_alert_email'				=>'Default Alert Email:',
		'admin_email'						=>'Admins Email Address:',
		'email_fetch'						=>'Email Fetching:',
		'enable'							=>'Enable',
		'default_MTA'						=>'Default MTA',
		'fetch_auto-corn'					=>'Fetch on auto-cron',
		'strip_quoted_reply'				=>'Strip Quoted Reply',
		'reply_separator'					=>'Reply Separator Tag',
		'accept_all_email'					=>'Accept All Emails',
		'accept_email_unknown'				=>'Accept email from unknown Users',
		'accept_email_collab'				=>'Accept Email Collaborators',
		'automatically_and_collab_from_email'=>'Automatically add collaborators from email fields',
		'default_alert_email'				=>'Default Alert Email',
		'attachments'							=>'Attachments',
		'email_attahment_user'				=>'Email attachments to the user',



      /*
      |--------------------------------------
      |   Ticket Settings Page
      |--------------------------------------
     */

      	'ticket'							=>'Ticket',
		'default_ticket_number_format'		=>'Default Ticket Number Format',
		'default_ticket_number_sequence'	=>'Default Ticket Number Sequence',
		'default_status'					=>'Default Status',
		'default_priority'					=>'Default Priority',
		'default_sla'						=>'Default SLA',
		'default_help_topic'				=>'Default Help Topic',
		'maximum_open_tickets'				=>'Maximum Open Tickets',
		'agent_collision_avoidance_duration'=>'Agent Collision Avoidance Duration',
		'human_verification'				=>'Human Verification',
		'claim_on_response'					=>'Claim on Response',
		'assigned_tickets'					=>'Assigned Tickets',
		'answered_tickets'					=>'Answered Tickets',
		'agent_identity_masking'			=>'Agent Identity Masking',
		'enable_HTML_ticket_thread'			=>'Enable HTML Ticket Thread',
		'allow_client_updates'				=>'Allow Client Updates',



      /*
      |--------------------------------------
      |   Access Settings Page
      |--------------------------------------
     */

      	'access'											=>'Access',
      	'expiration_policy'									=>'Password Expiration Policy',
		'allow_password_resets'								=>'Allow Password Resets',  
		'reset_token_expiration'							=>'Reset Token Expiration', 
		'agent_session_timeout'								=>'Agent Session Timeout', 
		'bind_agent_session_IP'								=>'Bind Agent Session to IP',  
		'registration_required'								=>'Registration Required',   
		'require_registration_and_login_to_create_tickets'	=>'Require registration and login to create tickets',
		'registration_method'								=>'Registration Method', 
		'user_session_timeout'								=>'User Session Timeout', 
		'client_quick_access'								=>'Client Quick Access',

      /*
      |--------------------------------------
      |   Auto-Response Settings Page
      |--------------------------------------
     */

      	'auto_responce'					=>'Auto-Responce',
		'new_ticket'					=>'New Ticket',
		'new_ticket_by_agent'			=>'New Ticket by Agent',
		'new_message'					=>'New Message',
		'submitter'						=>'Submitter : ',
		'send_receipt_confirmation'		=>'Send Receipt Confirmation',
		'participants'					=>'Participants : ',
		'send_new_activity_notice'		=>'Send new activity notice',
		'overlimit_notice'				=>'Overlimit Notice',
		'email_attachments_to_the_user'	=>'Email attachments to the user',

      /*
      |--------------------------------------
      |   Alert & Notice Settings Page
      |--------------------------------------
     */

      	'alert_notices'						=>'Alert & Notices',
      	'new_ticket_alert'					=>'New Ticket Alert', 
       	'department_manager'				=>'Department Manager',
		'department_members'				=>'Department Members',
		'organization_account_manager'		=>'Organization Account Manager',
		'new_message_alert'					=>'New Message Alert',
		'last_respondent'					=>'Last Respondent',
		'assigned_agent_team'				=>'Assigned Agent / Team',
		'new_internal_note_alert'			=>'New Internal Note Alert',
		'ticket_assignment_alert'			=>'Ticket Assignment Alert', 
		'team_lead'							=>'Team Lead',
		'team_members'						=>'Team Members',
		'ticket_transfer_alert'				=>'Ticket Transfer Alert', 
		'overdue_ticket_alert'				=>'Overdue Ticket Alert ',
		'system_alerts'						=>'System Alerts', 
		'system_errors'						=>'System Errors',
		'SQL_errors'						=>'SQL errors',
		'excessive_failed_login_attempts'	=>'Excessive failed login attempts',
    
	/*
      |----------------------------------------------------------------------------------------
      | Manage Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Manage related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */

       /*
      |--------------------------------------
      |  Help Topic index Page
      |--------------------------------------
     */


		'topic'				=>'Topic',		
		'type'				=>'Type',	
		'priority'			=>'Priority',	
		'last_updated'		=>'Last Updated',
		'create_help_topic'	=>'Create Help topic',
		'action'			=>'Action',

	/*
      |--------------------------------------
      |  Help Topic Create Page
      |--------------------------------------
     */

		'active'				=>'Active',	
		'disabled'				=>'Disabled',
		'public'				=>'Public',
		'private'				=>'Private',
		'parent_topic'			=>'Parent Topic',
		'Custom_form'			=>'Custom Form',
		'SLA_plan'				=>'SLA Plan',
		'auto_assign'			=>'Auto assign', 
		'auto_respons'			=>'Auto Respons',
		'ticket_number_format'	=>'Ticket Number Format',
		'system_default'		=>'System Default',	
		'custom'				=>'Custom',
		'internal_notes'		=>'Internal Notes',


	/*
      |--------------------------------------
      |  SLA plan Index Page
      |--------------------------------------
     */

		'create_SLA'		=>'Create a SLA',
		'grace_period'		=>'Grace Period',	
		'added_date'		=>'Added Date',	

	/*
      |--------------------------------------
      |  SLA plan Create Page
      |--------------------------------------
     */

      	'transient'				=>'Transient',
		'ticket_overdue_alert'	=>'Ticket Overdue Alerts',

	/*
      |--------------------------------------
      |  Form Create Page
      |--------------------------------------
     */

		'title'				=>'Title',
		'instruction'		=>'Instruction',
		'label'				=>'Label',		
		'visibility'		=>'Visibility',	
		'variable'			=>'Variable',
		'create_form'		=>'Create Form',
		'forms'				=>'Forms',


	/*
      |----------------------------------------------------------------------------------------
      | Emails Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Emails related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */


	/*
      |--------------------------------------
      |  Emails Create Page
      |--------------------------------------
     */

      	'create_email'				=>'Create Email',
		'email_address'				=>'Email Address',
		'email_name'				=>'Email Name',
		'help_topic'				=>'Help Topic',
		'auto_response'				=>'Auto Response',
		'host_name'					=>'Host Name',
		'port_number'				=>'Port Number',
		'mail_box_protocol'			=>'Mail Box Protocol',
		'authentication_required'	=>'Authentication Required',
		'yes'						=>'Yes',	
		'no'						=>'No',
		'header_spoofing'			=>'Header Spoofing',
		'allow_for_this_email'		=>'Allow For This Email',
		'imap_config'				=>'IMAP Configuration',

	/*
      |--------------------------------------
      |  Ban Emails Create Page
      |--------------------------------------
     */

      	'ban_email'		=>'Ban Email',
      	'banlists'		=>'Ban lists',
	  	'ban_status'	=>'Ban Status',

	/*
      |--------------------------------------
      |  Templates Index Page
      |--------------------------------------
     */

		'templates'			=>'Templates',
		'create_template'	=>'Create Template',
		'in_use'			=>'In Use',	

	/*
      |--------------------------------------
      |  Templates Create Page
      |--------------------------------------
     */

		'template_set_to_clone'	=>'Template set to clone',
		'language'				=>'Language',


	/*
      |--------------------------------------
      |  Diagnostics Page
      |--------------------------------------
     */

		'diagnostics'		=>'Diagnostics',
		'from'				=>'From',
		'to'				=>'To',
		'subject'			=>'Subject',
		'message'			=>'Message',
		'send'				=>'Send',


	/*
      |----------------------------------------------------------------------------------------
      | Staff Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Staff related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */

    /*
      |--------------------------------------
      |  Staff Create Page
      |--------------------------------------
     */

      	'create_agent'				=>'Create Agent',	
		'first_name'				=>'First Name',	
		'last_name'					=>'Last Name',		
		'mobile_number'				=>'Mobile Number',	
		'agent_signature'			=>'Agent Signature',
		'account_status_setting'	=>'Account Status & Setting',
		'account_type'				=>'Account Type',	
		'admin'						=>'Admin',  
		'agent'						=>'Agent',
		'account_status'			=>'Account Status',	  
		'locked'					=>'Locked',
		'assigned_group'			=>'Assigned Group',	
		'primary_department'		=>'Primary Department',	
		'agent_time_zone'			=>'Agent Time Zone',	
		'day_light_saving'			=>'Day Light Saving',	
		'limit_access'				=>'Limit Access',	
		'directory_listing'			=>'Directory Listing',	
		'vocation_mode'				=>'Vocation Mode',	
		'assigned_team'				=>'Assigned Team',


	/*
      |--------------------------------------
      |  Department Create Page
      |--------------------------------------
     */

		'create_department'									=>'Create Department',
		'manager'											=>'Manager',	
		'ticket_assignment'									=>'Ticket Assignment ',	 
		'restrict_ticket_assignment_to_department_members'	=>'Restrict ticket assignment to department members',
		'outgoing_emails'									=>'Outgoing Emails',	
		'template_set'										=>'Template Set',	
		'auto_responding_settings'							=>'Auto-Responding Settigs', 
		'disable_for_this_department'						=>'Disable for this department',
		'auto_response_email'								=>'Auto-Response Email',	
		'recipient'											=>'Recipient',
		'group_access'										=>'Group Access',	
		'department_signature'								=>'Department Signature',

	 /*
      |--------------------------------------
      |  Team Create Page
      |--------------------------------------
     */

		'create_team'=>'Create Team',
		'team_lead'=>'Team Lead',	
		'assignment_alert'=>'Assignment Alert',
		'disable_for_this_team'=>'Disable for this team',
		'teams'=>'Teams',

	/*
      |--------------------------------------
      |  Group Create Page
      |--------------------------------------
     */

      	'create_group'			=>'Create Group',
      	'goups'					=>'Goups',
		'can_create_ticket'		=>'Can create ticket',	
		'can_edit_ticket'		=>'Can edit ticket',	
		'can_post_ticket'		=>'Can post Ticket',	
		'can_close_ticket'		=>'Can close ticket ',	
		'can_assign_ticket'		=>'Can assign ticket',	
		'can_transfer_ticket'	=>'Can transfer ticket',	
		'can_delete_ticket'		=>'Can delete ticket',	
		'can_ban_emails'		=>'Can ban emails',	
		'can_manage_premade'	=>'Can Manage premade',	
		'can_manage_FAQ'		=>'Can manage FAQ',	
		'can_view_agent_stats'	=>'Can view agent stats',	
		'department_access'		=>'Department Access ',
		'admin_notes'			=>'Admin Notes',
		'group_members'			=>'Group Members',
		'group_name'			=>'Group Name',


	/*
      |----------------------------------------------------------------------------------------
      | Agent Panel [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Agent Panel related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */


    /*
      |------------------------------------------------
      |User Page
      |------------------------------------------------
	 */

      	'user'			=>		'User',
      	'create_user'	=>		'Create User',
      	'full_name'		=>		'Full Name',

    /*
     |------------------------------------------------
     |Organization Page
     |------------------------------------------------
	*/

     	'organization'			=>		'Organization',
     	'create_organization'	=>		'Create Organization',
     	'account_manager'		=>		'Account Manager',

     /*
     |------------------------------------------------
     |Guest-User Page
     |------------------------------------------------
	*/
     	'issue_summary'			=>		'Issue Summary',
     	'issue_details'			=>		'Issue Details',
     	'contact_informations'	=>		'Contact Informations',
     	'contact_details'		=>		'Contact Details',
     	'role'					=>		'Role',
     	'ext'					=>		'EXT',
     	'profile_pic'			=>		'Profile Picture',
     	'male'					=>		'Male',
     	'female'				=>		'Female',
     	'old_password'			=>		'Old Password',
     	'new_password'			=>		'New Password',
     	'confirm_password'		=>		'Confirm Password',
     	'gender' 				=>		'Gender',
     	'ticket_number'			=>		'Ticket Number',
     	'content'				=>		'Content',

    );