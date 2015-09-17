<?php

use App\Model\Agent\Department;
use App\Model\Agent\Groups;
use App\Model\Agent\Teams;
use App\Model\Form\Form_details;
use App\Model\Form\Form_name;
use App\Model\Guest\Guest_note;
use App\Model\Manage\Help_topic;
use App\Model\Manage\Sla_plan;
use App\Model\Settings\Ticket;
use App\Model\Ticket\Ticket_Priority;
use App\Model\Ticket\Ticket_Status;
use App\Model\Utility\Date_format;
use App\Model\Utility\Date_time_format;
use App\Model\Utility\Languages;
use App\Model\Utility\Logs;
use App\Model\Utility\MailboxProtocol;
use App\Model\Utility\Timezones;
use App\Model\Utility\Time_format;
use App\Model\Utility\Priority;
use Illuminate\Database\Seeder;
use App\Model\Settings\Access;
use App\Model\Settings\Alert;
use App\Model\Settings\Company;
use App\Model\Settings\Email;
use App\Model\Settings\Responder;
use App\Model\Settings\System;
use App\Model\Ticket\Ticket_source;
use App\Model\Theme\Footer;
use App\Model\Theme\Footer2;
use App\Model\Theme\Footer3;
use App\Model\Theme\Footer4;
use App\Model\Email\Smtp;





class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		Time_format::create(array('format' => 'H:i:s'));
		Time_format::create(array('format' => 'H.i.s'));

		$timezone = ['Pacific/Midway' => '(GMT-11:00) Midway Island',
			'US/Samoa' => '(GMT-11:00) Samoa',
			'US/Hawaii' => '(GMT-10:00) Hawaii',
			'US/Alaska' => '(GMT-09:00) Alaska',
			'US/Pacific' => '(GMT-08:00) Pacific Time (US &amp; Canada)',
			'America/Tijuana' => '(GMT-08:00) Tijuana',
			'US/Arizona' => '(GMT-07:00) Arizona',
			'US/Mountain' => '(GMT-07:00) Mountain Time (US &amp; Canada)',
			'America/Chihuahua' => '(GMT-07:00) Chihuahua',
			'America/Mazatlan' => '(GMT-07:00) Mazatlan',
			'America/Mexico_City' => '(GMT-06:00) Mexico City',
			'America/Monterrey' => '(GMT-06:00) Monterrey',
			'Canada/Saskatchewan' => '(GMT-06:00) Saskatchewan',
			'US/Central' => '(GMT-06:00) Central Time (US &amp; Canada)',
			'US/Eastern' => '(GMT-05:00) Eastern Time (US &amp; Canada)',
			'US/East-Indiana' => '(GMT-05:00) Indiana (East)',
			'America/Bogota' => '(GMT-05:00) Bogota',
			'America/Lima' => '(GMT-05:00) Lima',
			'America/Caracas' => '(GMT-04:30) Caracas',
			'Canada/Atlantic' => '(GMT-04:00) Atlantic Time (Canada)',
			'America/La_Paz' => '(GMT-04:00) La Paz',
			'America/Santiago' => '(GMT-04:00) Santiago',
			'Canada/Newfoundland' => '(GMT-03:30) Newfoundland',
			'America/Buenos_Aires' => '(GMT-03:00) Buenos Aires',
			'Greenland' => '(GMT-03:00) Greenland',
			'Atlantic/Stanley' => '(GMT-02:00) Stanley',
			'Atlantic/Azores' => '(GMT-01:00) Azores',
			'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
			'Africa/Casablanca' => '(GMT) Casablanca',
			'Europe/Dublin' => '(GMT) Dublin',
			'Europe/Lisbon' => '(GMT) Lisbon',
			'Europe/London' => '(GMT) London',
			'Africa/Monrovia' => '(GMT) Monrovia',
			'Europe/Amsterdam' => '(GMT+01:00) Amsterdam',
			'Europe/Belgrade' => '(GMT+01:00) Belgrade',
			'Europe/Berlin' => '(GMT+01:00) Berlin',
			'Europe/Bratislava' => '(GMT+01:00) Bratislava',
			'Europe/Brussels' => '(GMT+01:00) Brussels',
			'Europe/Budapest' => '(GMT+01:00) Budapest',
			'Europe/Copenhagen' => '(GMT+01:00) Copenhagen',
			'Europe/Ljubljana' => '(GMT+01:00) Ljubljana',
			'Europe/Madrid' => '(GMT+01:00) Madrid',
			'Europe/Paris' => '(GMT+01:00) Paris',
			'Europe/Prague' => '(GMT+01:00) Prague',
			'Europe/Rome' => '(GMT+01:00) Rome',
			'Europe/Sarajevo' => '(GMT+01:00) Sarajevo',
			'Europe/Skopje' => '(GMT+01:00) Skopje',
			'Europe/Stockholm' => '(GMT+01:00) Stockholm',
			'Europe/Vienna' => '(GMT+01:00) Vienna',
			'Europe/Warsaw' => '(GMT+01:00) Warsaw',
			'Europe/Zagreb' => '(GMT+01:00) Zagreb',
			'Europe/Athens' => '(GMT+02:00) Athens',
			'Europe/Bucharest' => '(GMT+02:00) Bucharest',
			'Africa/Cairo' => '(GMT+02:00) Cairo',
			'Africa/Harare' => '(GMT+02:00) Harare',
			'Europe/Helsinki' => '(GMT+02:00) Helsinki',
			'Europe/Istanbul' => '(GMT+02:00) Istanbul',
			'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
			'Europe/Kiev' => '(GMT+02:00) Kyiv',
			'Europe/Minsk' => '(GMT+02:00) Minsk',
			'Europe/Riga' => '(GMT+02:00) Riga',
			'Europe/Sofia' => '(GMT+02:00) Sofia',
			'Europe/Tallinn' => '(GMT+02:00) Tallinn',
			'Europe/Vilnius' => '(GMT+02:00) Vilnius',
			'Asia/Baghdad' => '(GMT+03:00) Baghdad',
			'Asia/Kuwait' => '(GMT+03:00) Kuwait',
			'Africa/Nairobi' => '(GMT+03:00) Nairobi',
			'Asia/Riyadh' => '(GMT+03:00) Riyadh',
			'Asia/Tehran' => '(GMT+03:30) Tehran',
			'Europe/Moscow' => '(GMT+04:00) Moscow',
			'Asia/Baku' => '(GMT+04:00) Baku',
			'Europe/Volgograd' => '(GMT+04:00) Volgograd',
			'Asia/Muscat' => '(GMT+04:00) Muscat',
			'Asia/Tbilisi' => '(GMT+04:00) Tbilisi',
			'Asia/Yerevan' => '(GMT+04:00) Yerevan',
			'Asia/Kabul' => '(GMT+04:30) Kabul',
			'Asia/Karachi' => '(GMT+05:00) Karachi',
			'Asia/Tashkent' => '(GMT+05:00) Tashkent',
			'Asia/Kolkata' => '(GMT+05:30) Kolkata',
			'Asia/Kathmandu' => '(GMT+05:45) Kathmandu',
			'Asia/Yekaterinburg' => '(GMT+06:00) Ekaterinburg',
			'Asia/Almaty' => '(GMT+06:00) Almaty',
			'Asia/Dhaka' => '(GMT+06:00) Dhaka',
			'Asia/Novosibirsk' => '(GMT+07:00) Novosibirsk',
			'Asia/Bangkok' => '(GMT+07:00) Bangkok',
			'Asia/Ho_Chi_Minh' => '(GMT+07.00) Ho Chi Minh',
			'Asia/Jakarta' => '(GMT+07:00) Jakarta',
			'Asia/Krasnoyarsk' => '(GMT+08:00) Krasnoyarsk',
			'Asia/Chongqing' => '(GMT+08:00) Chongqing',
			'Asia/Hong_Kong' => '(GMT+08:00) Hong Kong',
			'Asia/Kuala_Lumpur' => '(GMT+08:00) Kuala Lumpur',
			'Australia/Perth' => '(GMT+08:00) Perth',
			'Asia/Singapore' => '(GMT+08:00) Singapore',
			'Asia/Taipei' => '(GMT+08:00) Taipei',
			'Asia/Ulaanbaatar' => '(GMT+08:00) Ulaan Bataar',
			'Asia/Urumqi' => '(GMT+08:00) Urumqi',
			'Asia/Irkutsk' => '(GMT+09:00) Irkutsk',
			'Asia/Seoul' => '(GMT+09:00) Seoul',
			'Asia/Tokyo' => '(GMT+09:00) Tokyo',
			'Australia/Adelaide' => '(GMT+09:30) Adelaide',
			'Australia/Darwin' => '(GMT+09:30) Darwin',
			'Asia/Yakutsk' => '(GMT+10:00) Yakutsk',
			'Australia/Brisbane' => '(GMT+10:00) Brisbane',
			'Australia/Canberra' => '(GMT+10:00) Canberra',
			'Pacific/Guam' => '(GMT+10:00) Guam',
			'Australia/Hobart' => '(GMT+10:00) Hobart',
			'Australia/Melbourne' => '(GMT+10:00) Melbourne',
			'Pacific/Port_Moresby' => '(GMT+10:00) Port Moresby',
			'Australia/Sydney' => '(GMT+10:00) Sydney',
			'Asia/Vladivostok' => '(GMT+11:00) Vladivostok',
			'Asia/Magadan' => '(GMT+12:00) Magadan',
			'Pacific/Auckland' => '(GMT+12:00) Auckland',
			'Pacific/Fiji' => '(GMT+12:00) Fiji'];

		foreach ($timezone as $name => $location) {
			Timezones::create(array('name' => $name, 'location' => $location));
		}

		Ticket_status::create(array('name' => 'Open', 'state' => 'open', 'mode' => '3', 'message'=>'Ticket have been Reopened by', 'flags' => '0', 'sort' => '1', 'properties' => 'Open tickets.'));
		Ticket_status::create(array('name' => 'Resolved', 'state' => 'closed', 'mode' => '1','message'=>'Ticket have been Resolved by', 'flags' => '0', 'sort' => '2', 'properties' => 'Resolved tickets.'));
		Ticket_status::create(array('name' => 'Closed', 'state' => 'closed', 'mode' => '3','message'=>'Ticket have been Closed by', 'flags' => '0', 'sort' => '3', 'properties' => 'Closed tickets. Tickets will still be accessible on client and staff panels.'));
		Ticket_status::create(array('name' => 'Archived', 'state' => 'archived', 'mode' => '3','message'=>'Ticket have been Archived by', 'flags' => '0', 'sort' => '4', 'properties' => 'Tickets only adminstratively available but no longer accessible on ticket queues and client panel.'));
		Ticket_status::create(array('name' => 'Deleted', 'state' => 'deleted', 'mode' => '3','message'=>'Ticket have been Deleted by', 'flags' => '0', 'sort' => '5', 'properties' => 'Tickets queued for deletion. Not accessible on ticket queues.'));

		Ticket::create(array('num_format' => '#ABCD 1234 1234567', 'num_sequence' => '0', 'priority' => 'low', 'sla' => '12 Hours', 'help_topic' => 'support query'));

		Ticket_priority::create(array('priority' => 'low', 'priority_desc' => 'Low', 'priority_color' => 'info', 'priority_urgency' => '4', 'ispublic' => '1'));
		Ticket_priority::create(array('priority' => 'normal', 'priority_desc' => 'Normal', 'priority_color' => 'info', 'priority_urgency' => '3', 'ispublic' => '1'));
		Ticket_priority::create(array('priority' => 'high', 'priority_desc' => 'High', 'priority_color' => 'warning', 'priority_urgency' => '2', 'ispublic' => '1'));
		Ticket_priority::create(array('priority' => 'emergency', 'priority_desc' => 'Emergency', 'priority_color' => 'danger', 'priority_urgency' => '1', 'ispublic' => '1'));

		Sla_plan::create(array('name' => 'Sla 1', 'grace_period' => '6 Hours', 'status' => '1'));
		Sla_plan::create(array('name' => 'Sla 2', 'grace_period' => '12 Hours', 'status' => '1'));
		Sla_plan::create(array('name' => 'Sla 3', 'grace_period' => '24 Hours', 'status' => '1'));

		$mailbox = ['IMAP+SSl', 'IMAP', 'POP+SSL', 'POP'];

		foreach ($mailbox as $protocol) {
			MailboxProtocol::create(array('name' => $protocol));
		}

		$logs = ['WARN', 'DEBUG', 'ERROR'];

		foreach ($logs as $log) {
			Logs::create(['level' => $log]);
		}

		$languages = [
			'English' => 'en',
			'Italian' => 'it',
			'German' => 'de',
			'French' => 'fr',
			'Brazilian Portuguese' => 'pt_BR',
			'Dutch' => 'nl',
			'Spanish' => 'es',
			'Norwegian' => 'nb_NO',
			'Danish' => 'da'];

		foreach ($languages as $language => $locale) {
			Languages::create(['name' => $language, 'locale' => $locale]);
		}

		Guest_note::create(['heading' => 'Welcome to the Support Center', 'content' => 'Hello this is a new helpdesk support system ans it is in the development phase.']);

		Form_name::create(['name' => 'form', 'status' => '1', 'no_of_fields' => '2']);

		Form_details::create(['form_name_id' => '1', 'label' => 'Name', 'type' => 'text']);
		Form_details::create(['form_name_id' => '1', 'label' => 'Phone', 'type' => 'number']);
		Form_details::create(['form_name_id' => '1', 'label' => 'Email', 'type' => 'text']);
		Form_details::create(['form_name_id' => '1', 'label' => 'Subject', 'type' => 'text']);
		Form_details::create(['form_name_id' => '1', 'label' => 'Details', 'type' => 'textarea']);

		$date_time_formats = [
			'd/m/Y  H:i:s',
			'd.m.Y  H:i:s',
			'd-m-Y  H:i:s',
			'm/d/Y  H:i:s',
			'm.d.Y  H:i:s',
			'm-d-Y  H:i:s',
			'Y/m/d  H:i:s',
			'Y.m.d  H:i:s',
			'Y-m-d  H:i:s'];

		foreach ($date_time_formats as $date_time_format) {
			Date_time_format::create(['format' => $date_time_format]);
		}

		$date_formats = [
			'dd/mm/yyyy',
			'dd-mm-yyyy',
			'dd.mm.yyyy',
			'mm/dd/yyyy',
			'mm:dd:yyyy',
			'mm-dd-yyyy',
			'dd-mm-yyyy',
			'yyyy/mm/dd',
			'yyyy.mm.dd',
			'yyyy-mm-dd'];

		foreach ($date_formats as $date_format) {
			Date_format::create(['format' => $date_format]);
		}

		Teams::create(array('name' => 'Level 1 Support'));
		Teams::create(array('name' => 'Level 2 Support'));
		Teams::create(array('name' => 'Developer'));

		Groups::create(array('name' => 'Group A', 'group_status' => '1', 'can_create_ticket' => '1', 'can_edit_ticket' => '1', 'can_post_ticket' => '1', 'can_close_ticket' => '1', 'can_assign_ticket' => '1', 'can_transfer_ticket' => '1', 'can_delete_ticket' => '1', 'can_ban_email' => '1', 'can_manage_canned' => '1', 'can_manage_faq' => '1', 'can_view_agent_stats' => '1', 'department_access' => '1'));
		Groups::create(array('name' => 'Group B', 'group_status' => '1', 'can_create_ticket' => '1', 'can_edit_ticket' => '0', 'can_post_ticket' => '0', 'can_close_ticket' => '1', 'can_assign_ticket' => '1', 'can_transfer_ticket' => '1', 'can_delete_ticket' => '1', 'can_ban_email' => '1', 'can_manage_canned' => '1', 'can_manage_faq' => '1', 'can_view_agent_stats' => '1', 'department_access' => '1'));
		Groups::create(array('name' => 'Group C', 'group_status' => '1', 'can_create_ticket' => '0', 'can_edit_ticket' => '0', 'can_post_ticket' => '0', 'can_close_ticket' => '1', 'can_assign_ticket' => '0', 'can_transfer_ticket' => '0', 'can_delete_ticket' => '0', 'can_ban_email' => '0', 'can_manage_canned' => '0', 'can_manage_faq' => '0', 'can_view_agent_stats' => '0', 'department_access' => '0'));

		Department::create(array('name' => 'Support'));
		Department::create(array('name' => 'Sales'));
		Department::create(array('name' => 'Operation'));

		// Access::create(array('password_expire' => '1 Months', 'reg_method' => 'disable'));
		// Access::create(array('password_expire' => '2 Months', 'reg_method' => 'private'));
		// Access::create(array('password_expire' => '6 Months', 'reg_method' => 'public'));

		// Company::create(array('company_name' => 'D company', 'website' => 'dcompany.org', 'phone' => '8606574126'));

		// Emails::create(array('email_address' => 'maintanance@dcompany.com', 'email_name' => 'maintain', 'department' => 'maintanance', 'priority' => 'low', 'help_topic' => 'maintanance query', 'user_name' => 'maintanance'));

		help_topic::create(array('topic' => 'Support query', 'parent_topic' => 'Support query', 'custom_form' => '1', 'department' => '1', 'ticket_status' => '1', 'priority' => '2', 'sla_plan' => '1', 'ticket_num_format' => '1', 'status' => '1', 'type' => '1', 'auto_response' => '0'));
		help_topic::create(array('topic' => 'Sales query', 'parent_topic' => 'Sale query', 'custom_form' => '1', 'department' => '2', 'ticket_status' => '1', 'priority' => '2', 'sla_plan' => '1', 'ticket_num_format' => '1', 'status' => '1', 'type' => '1', 'auto_response' => '0'));
		help_topic::create(array('topic' => 'Operational query', 'parent_topic' => 'Operational query', 'custom_form' => '1', 'department' => '3', 'ticket_status' => '1', 'priority' => '2', 'sla_plan' => '1', 'ticket_num_format' => '1', 'status' => '1', 'type' => '1', 'auto_response' => '0'));

		Priority::create(array('name' => 'low'));	
		Priority::create(array('name' => 'high'));

		Access::create(array('id' => '1'));
		Alert::create(array('id' => '1'));
		Company::create(array('id' => '1'));
		Email::create(array('id' => '1'));
		Responder::create(array('id' => '1'));
		System::create(array('id' => '1'));
		Footer::create(array('id' => '1'));
		Footer2::create(array('id' => '1'));
		Footer3::create(array('id' => '1'));
		Footer4::create(array('id' => '1'));
		// Ticket::create(array('id' => '1'));

		Ticket_source::create(array('name'=>'web', 'value'=>'Web'));
		Ticket_source::create(array('name'=>'email', 'value'=>'E-mail'));
		Ticket_source::create(array('name'=>'agent', 'value'=>'Agent Panel'));

		Smtp::create(array('id' => '1'));

	}
}