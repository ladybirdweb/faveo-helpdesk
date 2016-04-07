<?php

use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Agent\Groups;
use App\Model\helpdesk\Agent\Teams;
use App\Model\helpdesk\Email\Smtp;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Manage\Sla_plan;
use App\Model\helpdesk\Notification\NotificationType;
use App\Model\helpdesk\Settings\Alert;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Settings\Email;
use App\Model\helpdesk\Settings\Responder;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Settings\Ticket;
use App\Model\helpdesk\Theme\Widgets;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Ticket\Ticket_source;
use App\Model\helpdesk\Ticket\Ticket_Status;
use App\Model\helpdesk\Utility\Date_format;
use App\Model\helpdesk\Utility\Date_time_format;
use App\Model\helpdesk\Utility\Languages;
use App\Model\helpdesk\Utility\Log_notification;
use App\Model\helpdesk\Utility\MailboxProtocol;
use App\Model\helpdesk\Utility\Time_format;
use App\Model\helpdesk\Utility\Timezones;
use App\Model\helpdesk\Utility\Version_Check;
use App\Model\kb\Settings;
// Knowledge base
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* Date time format */
        $date_time_formats = [
            'd/m/Y H:i:s',
            'd.m.Y H:i:s',
            'd-m-Y H:i:s',
            'm/d/Y H:i:s',
            'm.d.Y H:i:s',
            'm-d-Y H:i:s',
            'Y/m/d H:i:s',
            'Y.m.d H:i:s',
            'Y-m-d H:i:s', ];

        foreach ($date_time_formats as $date_time_format) {
            Date_time_format::create(['format' => $date_time_format]);
        }
        /* Date format */
        $date_formats = [
            'dd/mm/yyyy',
            'dd-mm-yyyy',
            'dd.mm.yyyy',
            'mm/dd/yyyy',
            'mm:dd:yyyy',
            'mm-dd-yyyy',
            'yyyy/mm/dd',
            'yyyy.mm.dd',
            'yyyy-mm-dd', ];

        foreach ($date_formats as $date_format) {
            Date_format::create(['format' => $date_format]);
        }
        /* Time format */
        Time_format::create(['format' => 'H:i:s']);
        Time_format::create(['format' => 'H.i.s']);
        /* Timezone */
        $timezone = ['Pacific/Midway' => '(GMT-11:00) Midway Island',
            'US/Samoa'                => '(GMT-11:00) Samoa',
            'US/Hawaii'               => '(GMT-10:00) Hawaii',
            'US/Alaska'               => '(GMT-09:00) Alaska',
            'US/Pacific'              => '(GMT-08:00) Pacific Time (US &amp; Canada)',
            'America/Tijuana'         => '(GMT-08:00) Tijuana',
            'US/Arizona'              => '(GMT-07:00) Arizona',
            'US/Mountain'             => '(GMT-07:00) Mountain Time (US &amp; Canada)',
            'America/Chihuahua'       => '(GMT-07:00) Chihuahua',
            'America/Mazatlan'        => '(GMT-07:00) Mazatlan',
            'America/Mexico_City'     => '(GMT-06:00) Mexico City',
            'America/Monterrey'       => '(GMT-06:00) Monterrey',
            'Canada/Saskatchewan'     => '(GMT-06:00) Saskatchewan',
            'US/Central'              => '(GMT-06:00) Central Time (US &amp; Canada)',
            'US/Eastern'              => '(GMT-05:00) Eastern Time (US &amp; Canada)',
            'US/East-Indiana'         => '(GMT-05:00) Indiana (East)',
            'America/Bogota'          => '(GMT-05:00) Bogota',
            'America/Lima'            => '(GMT-05:00) Lima',
            'America/Caracas'         => '(GMT-04:30) Caracas',
            'Canada/Atlantic'         => '(GMT-04:00) Atlantic Time (Canada)',
            'America/La_Paz'          => '(GMT-04:00) La Paz',
            'America/Santiago'        => '(GMT-04:00) Santiago',
            'Canada/Newfoundland'     => '(GMT-03:30) Newfoundland',
            'America/Buenos_Aires'    => '(GMT-03:00) Buenos Aires',
            'Greenland'               => '(GMT-03:00) Greenland',
            'Atlantic/Stanley'        => '(GMT-02:00) Stanley',
            'Atlantic/Azores'         => '(GMT-01:00) Azores',
            'Atlantic/Cape_Verde'     => '(GMT-01:00) Cape Verde Is.',
            'Africa/Casablanca'       => '(GMT) Casablanca',
            'Europe/Dublin'           => '(GMT) Dublin',
            'Europe/Lisbon'           => '(GMT) Lisbon',
            'Europe/London'           => '(GMT) London',
            'Africa/Monrovia'         => '(GMT) Monrovia',
            'Europe/Amsterdam'        => '(GMT+01:00) Amsterdam',
            'Europe/Belgrade'         => '(GMT+01:00) Belgrade',
            'Europe/Berlin'           => '(GMT+01:00) Berlin',
            'Europe/Bratislava'       => '(GMT+01:00) Bratislava',
            'Europe/Brussels'         => '(GMT+01:00) Brussels',
            'Europe/Budapest'         => '(GMT+01:00) Budapest',
            'Europe/Copenhagen'       => '(GMT+01:00) Copenhagen',
            'Europe/Ljubljana'        => '(GMT+01:00) Ljubljana',
            'Europe/Madrid'           => '(GMT+01:00) Madrid',
            'Europe/Paris'            => '(GMT+01:00) Paris',
            'Europe/Prague'           => '(GMT+01:00) Prague',
            'Europe/Rome'             => '(GMT+01:00) Rome',
            'Europe/Sarajevo'         => '(GMT+01:00) Sarajevo',
            'Europe/Skopje'           => '(GMT+01:00) Skopje',
            'Europe/Stockholm'        => '(GMT+01:00) Stockholm',
            'Europe/Vienna'           => '(GMT+01:00) Vienna',
            'Europe/Warsaw'           => '(GMT+01:00) Warsaw',
            'Europe/Zagreb'           => '(GMT+01:00) Zagreb',
            'Europe/Athens'           => '(GMT+02:00) Athens',
            'Europe/Bucharest'        => '(GMT+02:00) Bucharest',
            'Africa/Cairo'            => '(GMT+02:00) Cairo',
            'Africa/Harare'           => '(GMT+02:00) Harare',
            'Europe/Helsinki'         => '(GMT+02:00) Helsinki',
            'Europe/Istanbul'         => '(GMT+02:00) Istanbul',
            'Asia/Jerusalem'          => '(GMT+02:00) Jerusalem',
            'Europe/Kiev'             => '(GMT+02:00) Kyiv',
            'Europe/Minsk'            => '(GMT+02:00) Minsk',
            'Europe/Riga'             => '(GMT+02:00) Riga',
            'Europe/Sofia'            => '(GMT+02:00) Sofia',
            'Europe/Tallinn'          => '(GMT+02:00) Tallinn',
            'Europe/Vilnius'          => '(GMT+02:00) Vilnius',
            'Asia/Baghdad'            => '(GMT+03:00) Baghdad',
            'Asia/Kuwait'             => '(GMT+03:00) Kuwait',
            'Africa/Nairobi'          => '(GMT+03:00) Nairobi',
            'Asia/Riyadh'             => '(GMT+03:00) Riyadh',
            'Asia/Tehran'             => '(GMT+03:30) Tehran',
            'Europe/Moscow'           => '(GMT+04:00) Moscow',
            'Asia/Baku'               => '(GMT+04:00) Baku',
            'Europe/Volgograd'        => '(GMT+04:00) Volgograd',
            'Asia/Muscat'             => '(GMT+04:00) Muscat',
            'Asia/Tbilisi'            => '(GMT+04:00) Tbilisi',
            'Asia/Yerevan'            => '(GMT+04:00) Yerevan',
            'Asia/Kabul'              => '(GMT+04:30) Kabul',
            'Asia/Karachi'            => '(GMT+05:00) Karachi',
            'Asia/Tashkent'           => '(GMT+05:00) Tashkent',
            'Asia/Kolkata'            => '(GMT+05:30) Kolkata',
            'Asia/Kathmandu'          => '(GMT+05:45) Kathmandu',
            'Asia/Yekaterinburg'      => '(GMT+06:00) Ekaterinburg',
            'Asia/Almaty'             => '(GMT+06:00) Almaty',
            'Asia/Dhaka'              => '(GMT+06:00) Dhaka',
            'Asia/Novosibirsk'        => '(GMT+07:00) Novosibirsk',
            'Asia/Bangkok'            => '(GMT+07:00) Bangkok',
            'Asia/Ho_Chi_Minh'        => '(GMT+07.00) Ho Chi Minh',
            'Asia/Jakarta'            => '(GMT+07:00) Jakarta',
            'Asia/Krasnoyarsk'        => '(GMT+08:00) Krasnoyarsk',
            'Asia/Chongqing'          => '(GMT+08:00) Chongqing',
            'Asia/Hong_Kong'          => '(GMT+08:00) Hong Kong',
            'Asia/Kuala_Lumpur'       => '(GMT+08:00) Kuala Lumpur',
            'Australia/Perth'         => '(GMT+08:00) Perth',
            'Asia/Singapore'          => '(GMT+08:00) Singapore',
            'Asia/Taipei'             => '(GMT+08:00) Taipei',
            'Asia/Ulaanbaatar'        => '(GMT+08:00) Ulaan Bataar',
            'Asia/Urumqi'             => '(GMT+08:00) Urumqi',
            'Asia/Irkutsk'            => '(GMT+09:00) Irkutsk',
            'Asia/Seoul'              => '(GMT+09:00) Seoul',
            'Asia/Tokyo'              => '(GMT+09:00) Tokyo',
            'Australia/Adelaide'      => '(GMT+09:30) Adelaide',
            'Australia/Darwin'        => '(GMT+09:30) Darwin',
            'Asia/Yakutsk'            => '(GMT+10:00) Yakutsk',
            'Australia/Brisbane'      => '(GMT+10:00) Brisbane',
            'Australia/Canberra'      => '(GMT+10:00) Canberra',
            'Pacific/Guam'            => '(GMT+10:00) Guam',
            'Australia/Hobart'        => '(GMT+10:00) Hobart',
            'Australia/Melbourne'     => '(GMT+10:00) Melbourne',
            'Pacific/Port_Moresby'    => '(GMT+10:00) Port Moresby',
            'Australia/Sydney'        => '(GMT+10:00) Sydney',
            'Asia/Vladivostok'        => '(GMT+11:00) Vladivostok',
            'Asia/Magadan'            => '(GMT+12:00) Magadan',
            'Pacific/Auckland'        => '(GMT+12:00) Auckland',
            'Pacific/Fiji'            => '(GMT+12:00) Fiji', ];

        foreach ($timezone as $name => $location) {
            Timezones::create(['name' => $name, 'location' => $location]);
        }
        /* Ticket status */
        Ticket_status::create(['name' => 'Open', 'state' => 'open', 'mode' => '3', 'message' => 'Ticket have been Reopened by', 'flags' => '0', 'sort' => '1', 'properties' => 'Open tickets.']);
        Ticket_status::create(['name' => 'Resolved', 'state' => 'closed', 'mode' => '1', 'message' => 'Ticket have been Resolved by', 'flags' => '0', 'sort' => '2', 'properties' => 'Resolved tickets.']);
        Ticket_status::create(['name' => 'Closed', 'state' => 'closed', 'mode' => '3', 'message' => 'Ticket have been Closed by', 'flags' => '0', 'sort' => '3', 'properties' => 'Closed tickets. Tickets will still be accessible on client and staff panels.']);
        Ticket_status::create(['name' => 'Archived', 'state' => 'archived', 'mode' => '3', 'message' => 'Ticket have been Archived by', 'flags' => '0', 'sort' => '4', 'properties' => 'Tickets only adminstratively available but no longer accessible on ticket queues and client panel.']);
        Ticket_status::create(['name' => 'Deleted', 'state' => 'deleted', 'mode' => '3', 'message' => 'Ticket have been Deleted by', 'flags' => '0', 'sort' => '5', 'properties' => 'Tickets queued for deletion. Not accessible on ticket queues.']);
        /* Ticket priority */
        Ticket_priority::create(['priority' => 'low', 'priority_desc' => 'Low', 'priority_color' => 'info', 'priority_urgency' => '4', 'ispublic' => '1']);
        Ticket_priority::create(['priority' => 'normal', 'priority_desc' => 'Normal', 'priority_color' => 'info', 'priority_urgency' => '3', 'ispublic' => '1']);
        Ticket_priority::create(['priority' => 'high', 'priority_desc' => 'High', 'priority_color' => 'warning', 'priority_urgency' => '2', 'ispublic' => '1']);
        Ticket_priority::create(['priority' => 'emergency', 'priority_desc' => 'Emergency', 'priority_color' => 'danger', 'priority_urgency' => '1', 'ispublic' => '1']);
        /* SLA Plans */
        Sla_plan::create(['name' => 'Sla 1', 'grace_period' => '6 Hours', 'status' => '1']);
        Sla_plan::create(['name' => 'Sla 2', 'grace_period' => '12 Hours', 'status' => '1']);
        Sla_plan::create(['name' => 'Sla 3', 'grace_period' => '24 Hours', 'status' => '1']);
        /* Mailbox protocol */
        $mailbox = [
            'IMAP'                 => '/imap',
            'IMAP+SSL'             => '/imap/ssl',
            'IMAP+TLS'             => '/imap/tls',
            'IMAP+SSL/No-validate' => '/imap/ssl/novalidate-cert', ];

        foreach ($mailbox as $name => $value) {
            MailboxProtocol::create(['name' => $name, 'value' => $value]);
        }
        /* Languages */
        $languages = [
            'English'              => 'en',
            'Italian'              => 'it',
            'German'               => 'de',
            'French'               => 'fr',
            'Brazilian Portuguese' => 'pt_BR',
            'Dutch'                => 'nl',
            'Spanish'              => 'es',
            'Norwegian'            => 'nb_NO',
            'Danish'               => 'da', ];

        foreach ($languages as $language => $locale) {
            Languages::create(['name' => $language, 'locale' => $locale]);
        }
        /* Teams */
        Teams::create(['name' => 'Level 1 Support', 'status' => '1']);
        Teams::create(['name' => 'Level 2 Support']);
        Teams::create(['name' => 'Developer']);
        /* Groups */
        Groups::create(['name' => 'Group A', 'group_status' => '1', 'can_create_ticket' => '1', 'can_edit_ticket' => '1', 'can_post_ticket' => '1', 'can_close_ticket' => '1', 'can_assign_ticket' => '1', 'can_transfer_ticket' => '1', 'can_delete_ticket' => '1', 'can_ban_email' => '1', 'can_manage_canned' => '1', 'can_view_agent_stats' => '1', 'department_access' => '1']);
        Groups::create(['name' => 'Group B', 'group_status' => '1', 'can_create_ticket' => '1', 'can_edit_ticket' => '0', 'can_post_ticket' => '0', 'can_close_ticket' => '1', 'can_assign_ticket' => '1', 'can_transfer_ticket' => '1', 'can_delete_ticket' => '1', 'can_ban_email' => '1', 'can_manage_canned' => '1', 'can_view_agent_stats' => '1', 'department_access' => '1']);
        Groups::create(['name' => 'Group C', 'group_status' => '1', 'can_create_ticket' => '0', 'can_edit_ticket' => '0', 'can_post_ticket' => '0', 'can_close_ticket' => '1', 'can_assign_ticket' => '0', 'can_transfer_ticket' => '0', 'can_delete_ticket' => '0', 'can_ban_email' => '0', 'can_manage_canned' => '0', 'can_view_agent_stats' => '0', 'department_access' => '0']);
        /* Department */
        Department::create(['name' => 'Support', 'sla' => '1']);
        Department::create(['name' => 'Sales', 'sla' => '1']);
        Department::create(['name' => 'Operation', 'sla' => '1']);
        /* Helptopic */
        help_topic::create(['topic' => 'Support query', 'department' => '1', 'ticket_status' => '1', 'priority' => '2', 'sla_plan' => '1', 'ticket_num_format' => '1', 'status' => '1', 'type' => '1', 'auto_response' => '0']);
        help_topic::create(['topic' => 'Sales query', 'department' => '2', 'ticket_status' => '1', 'priority' => '2', 'sla_plan' => '1', 'ticket_num_format' => '1', 'status' => '0', 'type' => '1', 'auto_response' => '0']);
        help_topic::create(['topic' => 'Operational query', 'department' => '3', 'ticket_status' => '1', 'priority' => '2', 'sla_plan' => '1', 'ticket_num_format' => '1', 'status' => '0', 'type' => '1', 'auto_response' => '0']);
        /* Daily notification log */
        Log_notification::create(['log' => 'NOT-1']);
        /* System complete settings */
        Alert::create(['id' => '1', 'ticket_status' => '1', 'ticket_admin_email' => '1', 'assignment_status' => '1', 'assignment_assigned_status' => '1', 'assignment_assigned_agent' => '1']);
        Company::create(['id' => '1']);
        Email::create(['id' => '1', 'template' => 'default', 'email_fetching' => '1', 'notification_cron' => '1', 'all_emails' => '1', 'email_collaborator' => '1', 'attachment' => '1']);
        Responder::create(['id' => '1', 'new_ticket' => '1', 'agent_new_ticket' => '1']);
        // System::create(array('id' => '1', 'status' => '1', 'department' => '1', 'date_time_format' => '1', 'time_zone' => '32'));
        Ticket::create(['num_format' => '#ABCD 1234 1234567', 'num_sequence' => '0', 'collision_avoid' => '2', 'priority' => '1', 'sla' => '2', 'help_topic' => '1', 'status' => '1']);
        /* Ticket source */
        Ticket_source::create(['name' => 'web', 'value' => 'Web']);
        Ticket_source::create(['name' => 'email', 'value' => 'E-mail']);
        Ticket_source::create(['name' => 'agent', 'value' => 'Agent Panel']);
        /* Mail configuration */
        Smtp::create(['id' => '1']);
        /* Version check */
        Version_Check::create(['id' => '1']);
        /* System widgets */
        Widgets::create(['id' => '1', 'name' => 'footer1']);
        Widgets::create(['id' => '2', 'name' => 'footer2']);
        Widgets::create(['id' => '3', 'name' => 'footer3']);
        Widgets::create(['id' => '4', 'name' => 'footer4']);
        Widgets::create(['id' => '5', 'name' => 'side1']);
        Widgets::create(['id' => '6', 'name' => 'side2']);
        Widgets::create(['id' => '7', 'name' => 'linkedin']);
        Widgets::create(['id' => '8', 'name' => 'stumble']);
        Widgets::create(['id' => '9', 'name' => 'google']);
        Widgets::create(['id' => '10', 'name' => 'deviantart']);
        Widgets::create(['id' => '11', 'name' => 'flickr']);
        Widgets::create(['id' => '12', 'name' => 'skype']);
        Widgets::create(['id' => '13', 'name' => 'rss']);
        Widgets::create(['id' => '14', 'name' => 'twitter']);
        Widgets::create(['id' => '15', 'name' => 'facebook']);
        Widgets::create(['id' => '16', 'name' => 'youtube']);
        Widgets::create(['id' => '17', 'name' => 'vimeo']);
        Widgets::create(['id' => '18', 'name' => 'pinterest']);
        Widgets::create(['id' => '19', 'name' => 'dribbble']);
        Widgets::create(['id' => '20', 'name' => 'instagram']);
        /* Knowledge base setting */
        Settings::create(['id' => 'id', 'pagination' => '10']);
        NotificationType::create(['id' => '1', 'message' => 'A new user is registered.', 'type' => 'registration', 'icon_class' => 'fa fa-user']);
        NotificationType::create(['id' => '2', 'message' => 'You have new reply on this ticket.', 'type' => 'reply', 'icon_class' => 'fa fa-envelope']);
        NotificationType::create(['id' => '3', 'message' => 'A new ticket has created.', 'type' => 'new_ticket', 'icon_class' => 'fa fa-envelope']);
    }
}
