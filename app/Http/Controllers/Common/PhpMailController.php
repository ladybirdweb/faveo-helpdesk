<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Model\Common\TemplateType;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Settings\Company;
use App\Model\helpdesk\Settings\Email;
use App\User;
use Auth;
use Mail;

class PhpMailController extends Controller
{
    /**
     *@var variable to instantiate common mailer class
     */
    protected $commonMailer;

    public function __construct()
    {
        $this->commonMailer = new CommonMailer();
    }

    public function fetch_smtp_details($id)
    {
        $emails = Emails::where('id', '=', $id)->first();

        return $emails;
    }

    /**
     * Fetching comapny name to send mail.
     *
     * @return type
     */
    public function company()
    {
        $company = Company::Where('id', '=', '1')->first();
        if ($company->company_name == null) {
            $company = 'Support Center';
        } else {
            $company = $company->company_name;
        }

        return $company;
    }

    /**
     * Function to choose from address.
     *
     * @param type Reg        $reg
     * @param type Department $dept_id
     *
     * @return type integer
     */
    public function mailfrom($reg, $dept_id)
    {
        $email_id = '';
        $emails = Emails::where('department', '=', $dept_id)->first();

        $email = Email::find(1);
        if ($emails && $emails->sending_status) {
            $email_id = $emails->id;
        } else {
            $email_id = $email->sys_email;
        }

        return $email_id;
    }

    public function sendmail($from, $to, $message, $template_variables, $thread = '', $auto_respond = '')
    {
        $this->setQueue();
        $job = new \App\Jobs\SendEmail($from, $to, $message, $template_variables, $thread, $auto_respond);
        dispatch($job);
    }

    public function sendEmail($from, $to, $message, $template_variables, $thread = '', $auto_respond = '')
    {
        $from_address = $this->fetch_smtp_details($from);
        if ($from_address == null) {
            loging('email-config', 'Invalid Email Configuration');
        }
        $this->setMailConfig($from_address);
        $recipants = $this->checkElement('email', $to);
        $recipantname = $this->checkElement('name', $to);
        $cc = $this->checkElement('cc', $to);
        $bc = $this->checkElement('bc', $to);
        $subject = $this->checkElement('subject', $message);
        $template_type = $this->checkElement('scenario', $message);
        $attachment = $this->checkElement('attachments', $message);
        $content_array = $this->mailTemplate($template_type, $template_variables, $message, $from, $subject);
        $content = $this->checkElement('body', $message);
        if ($content_array) {
            $content = checkArray('content', $content_array);
            $subject = checkArray('subject', $content_array);
        }
        $send = $this->laravelMail($recipants, $recipantname, $subject, $content, $from_address, $cc, $attachment, $thread, $auto_respond);

        return $send;
    }

    public function setMailConfig($mail)
    {
        switch ($mail->sending_protocol) {
            case 'smtp':
                $config = ['host'      => $mail->sending_host,
                            'port'     => $mail->sending_port,
                            'security' => $mail->sending_encryption,
                            'username' => $mail->user_name,
                            'password' => $mail->password,
                        ];
                if (!$this->commonMailer->setSmtpDriver($config)) {
                    \Log::info('Invaid configuration :- '.$config);

                    return 'invalid mail configuration';
                }
                break;
            case 'send_mail':
                $config = [
                            'host'     => \Config::get('mail.host'),
                            'port'     => \Config::get('mail.port'),
                            'security' => \Config::get('mail.encryption'),
                            'username' => \Config::get('mail.username'),
                            'password' => \Config::get('mail.password'),
                        ];
                $this->commonMailer->setSmtpDriver($config);
                break;
            case 'mailgun':
                $this->commonMailer->setMailGunDriver(null);
                break;
            default:
                return 'Mail driver not supported';
        }
    }

    public function setServices($emailid, $protocol)
    {
        $service = new \App\Model\MailJob\FaveoMail();
        $services = $service->where('email_id', $emailid)->pluck('value', 'key')->toArray();
        $controller = new \App\Http\Controllers\Admin\helpdesk\EmailsController();
        $controller->setServiceConfig($protocol, $services);
    }

    public function checkElement($element, $array)
    {
        $value = '';
        if (is_array($array)) {
            if (array_key_exists($element, $array)) {
                $value = $array[$element];
            }
        }

        return $value;
    }

    public function laravelMail($to, $toname, $subject, $data, $from_address, $cc = '', $attach = '', $thread = '', $auto_respond = '')
    {
        //dd($to, $toname, $subject, $data);
        $mail = Mail::send('emails.mail', ['data' => $data, 'thread' => $thread], function ($m) use ($to, $subject, $toname, $cc, $attach, $thread, $auto_respond,$from_address) {
            $m->to($to, $toname)->subject($subject);
            $m->from($from_address->email_address, $from_address->email_name);
            if ($auto_respond) {
                $swiftMessage = $m->getSwiftMessage();
                $headers = $swiftMessage->getHeaders();
                $headers->addTextHeader('X-Autoreply', 'true');
                $headers->addTextHeader('Auto-Submitted', 'auto-replied');
                $headers->addTextHeader('Content-Transfer-Encoding', 'base64');
            }
            if ($cc != null) {
                foreach ($cc as $cc_email) {
                    //mail to collaborators
                    $m->cc($cc_email);
                }
            }
            if ($thread && is_object($thread)) {
                $attach = $thread->attach()
                                        ->where('poster', 'ATTACHMENT')
                                        ->select('driver', 'name', 'path', 'type', \DB::raw('type as mime'), \DB::raw('name as file_name'), \DB::raw('path as file_path'), \DB::raw('path as file_path'), \DB::raw('path as file_path'), \DB::raw('file as data'), 'poster', 'file')->get()->toArray();
            }
            $size = count($attach);
            if ($size > 0) {
                for ($i = 0; $i < $size; $i++) {
                    if (is_array($attach) && array_key_exists($i, $attach)) {
                        $mode = 'normal';
                        $file = $attach[$i]['file'];
                        if (checkArray('poster', $attach[$i])) {
                            $file = $attach[$i]['file'];
                        }
                        if (checkArray('poster', $attach[$i]) && checkArray('data', $attach[$i])) {
                            $file = $attach[$i]['data'];
                            $mode = 'data';
                        }
                        if (is_array($attach[$i]) && array_key_exists('mode', $attach[$i])) {
                            $mode = $attach[$i]['mode'];
                        }

                        $name = $attach[$i]['file_name'];
                        $mime = $attach[$i]['mime'];

                        $this->attachmentMode($m, $file, $name, $mime, $mode);
                    }
                }
            }
        });
        //$this->updateFilePermission($attach, $mode);
        if (is_object($mail) || (is_object($mail) && $mail->getStatusCode() == 200)) {
            $mail = 1;
        }

        return $mail;
    }

    public function updateFilePermission($attach, $mode)
    {
        $size = count($attach);
        if ($size > 0) {
            for ($i = 0; $i < $size; $i++) {
                if (is_array($attach) && array_key_exists($i, $attach)) {
                    if (checkArray('poster', $attach[$i])) {
                        $file = $attach[$i]['file_path'].DIRECTORY_SEPARATOR.$attach[$i]['file_name'];
                        chmod($file, 1204);
                    }
                }
            }
        }
    }

    public function setQueue()
    {
        $short = 'database';
        $field = [
            'driver' => 'database',
            'table'  => 'jobs',
            'queue'  => 'default',
            'expire' => 60,
        ];
        $queue = new \App\Model\MailJob\QueueService();
        $active_queue = $queue->where('status', 1)->first();
        if ($active_queue) {
            $short = $active_queue->short_name;
            $fields = new \App\Model\MailJob\FaveoQueue();
            $field = $fields->where('service_id', $active_queue->id)->pluck('value', 'key')->toArray();
        }
        $this->setQueueConfig($short, $field);
    }

    public function setQueueConfig($short, $field)
    {
        \Config::set('queue.default', $short);
        foreach ($field as $key => $value) {
            \Config::set("queue.connections.$short.$key", $value);
        }
    }

    public function attachmentMode($message, $file, $name, $mime, $mode)
    {
        $m = $message->attachData(base64_decode($file, true), $name, ['mime' => $mime]);

        return $m;
    }

    public function mailTemplate($template_type, $template_variables, $message, $from, $subject)
    {
        $content = $this->checkElement('body', $message);
        $ticket_number = $this->checkElement('ticket_number', $template_variables);
        $template = TemplateType::where('name', '=', $template_type)->first();
        $status = \DB::table('settings_email')->first();
        $set = \App\Model\Common\TemplateSet::where('name', '=', $status->template)->first();
        $temp = [];
        if ($template) {
            $temp = $this->set($set, $ticket_number, $message, $template);
            $contents = $temp['content'];

            $variables = $this->templateVariables($template_variables, $content, $from);
            foreach ($variables as $k => $v) {
                $messagebody = str_replace($k, $v, $contents);
                $contents = $messagebody;
            }
            if ($template_type == 'ticket-reply-agent') {
                $line = '---Reply above this line--- <br/><br/>';
                $content = $line.$messagebody;
            } else {
                $content = $messagebody;
            }
        }
        if (checkArray('subject', $temp)) {
            $subject = checkArray('subject', $temp);
        }

        return ['content' => $content, 'subject' => $subject];
    }

    public function templateVariables($template_variables, $content, $from)
    {
        $agent = $this->checkElement('agent', $template_variables);
        // template variables
        if ($agent == '' && Auth::user()) {
            $agent = Auth::user()->user_name;
        }
        $system_from = $this->checkElement('system_from', $template_variables);
        if ($system_from === '') {
            $system_from = $this->company();
        }
        $system_link = $this->checkElement('system_link', $template_variables);
        if ($system_link === '') {
            $system_link = url('/');
        }
        $variables = [
            '{!!$user!!}'                    => checkArray('user', $template_variables),
            '{!!$agent!!}'                   => $agent,
            '{!!$ticket_number!!}'           => checkArray('ticket_number', $template_variables),
            '{!!$content!!}'                 => $content,
            '{!!$from!!}'                    => $from,
            '{!!$ticket_agent_name!!}'       => checkArray('ticket_agent_name', $template_variables),
            '{!!$ticket_client_name!!}'      => checkArray('ticket_client_name', $template_variables),
            '{!!$ticket_client_email!!}'     => checkArray('ticket_client_email', $template_variables),
            '{!!$ticket_body!!}'             => checkArray('ticket_body', $template_variables),
            '{!!$ticket_assigner!!}'         => checkArray('ticket_assigner', $template_variables),
            '{!!$ticket_link_with_number!!}' => checkArray('ticket_link_with_number', $template_variables),
            '{!!$system_error!!}'            => checkArray('system_error', $template_variables),
            '{!!$agent_sign!!}'              => checkArray('agent_sign', $template_variables),
            '{!!$department_sign!!}'         => checkArray('department_sign', $template_variables),
            '{!!$password_reset_link!!}'     => checkArray('password_reset_link', $template_variables),
            '{!!$email_address!!}'           => checkArray('email_address', $template_variables),
            '{!!$user_password!!}'           => checkArray('user_password', $template_variables),
            '{!!$system_from!!}'             => $system_from,
            '{!!$system_link!!}'             => $system_link,
            '{!!$duedate!!}'                 => checkArray('duedate', $template_variables),
            '{!!$requester!!}'               => checkArray('requester', $template_variables),
            '{!!$title!!}'                   => checkArray('title', $template_variables),
            '{!!$ticket_link!!}'             => checkArray('ticket_link', $template_variables),
            '{!!$by!!}'                      => checkArray('by', $template_variables),
            '{!!$internal_content!!}'        => checkArray('internal_content', $template_variables),
            '{!!$user_profile_link!!}'       => checkArray('user_profile_link', $template_variables),
        ];

        return $variables;
    }

    public function set($set, $ticket_number, $message, $template)
    {
        $contents = null;
        $subject = null;
        if (isset($set['id'])) {
            $subject = checkArray('subject', $message);
            $template_data = \App\Model\Common\Template::where('set_id', '=', $set->id)->where('type', '=', $template->id)->first();
            //dd($template_data);
            $contents = $template_data->message;
            if ($template_data->variable == 1) {
                if ($template_data->subject) {
                    $subject = $template_data->subject;
                    if ($ticket_number != null) {
                        $subject = $subject.' [#'.$ticket_number.']';
                    }
                }
            }
        }

        return ['content' => $contents, 'subject' => $subject];
    }
}
