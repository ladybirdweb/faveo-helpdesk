<?php

namespace App\Http\Controllers\Agent\helpdesk;

// controllers
use App;
// models
use App\Http\Controllers\Controller;
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Settings\Email;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Settings\Ticket;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_source;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
// classes
use App\Model\helpdesk\Utility\MailboxProtocol;
use Crypt;
use File;
use ForceUTF8\Encoding;
use App\Http\Controllers\Agent\helpdesk\ImapMail as ImapMailbox;
use Log;

/**
 * MailController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class MailController extends Controller {

    /**
     * constructor
     * Create a new controller instance.
     *
     * @param type TicketController $TicketController
     */
    public function __construct(TicketWorkflowController $TicketWorkflowController) {
        $this->middleware('board');
        $this->TicketWorkflowController = $TicketWorkflowController;
    }

    /**
     * Reademails.
     *
     * @return type
     */
    public function readmails(Emails $emails, Email $settings_email, System $system, Ticket $ticket) {
        if ($settings_email->first()->email_fetching == 1) {
            if ($settings_email->first()->all_emails == 1) {
                $email = $emails->get();
                if ($email->count() > 0) {
                    foreach ($email as $e_mail) {
                        $this->fetchEmail($e_mail);
                    }
                }
            }
        }
    }
    /**
     * get eamil array
     * @param object $e_mail
     */
    public function fetchEmail($e_mail) {
        $system = new System();
        $ticket = new Ticket();
        if ($e_mail->fetching_status == 1) {

            $host = $this->host($e_mail);
            $port = $this->port($e_mail);
            $protocol = $this->protocol($e_mail);
            $imap_config = '{' . $host . ':' . $port . $protocol . '}INBOX';

            $password = Crypt::decrypt($e_mail->password);
            $mailbox = new ImapMailbox($imap_config, $e_mail->email_address, $password, __DIR__);
            $mails = [];

            $mailsIds_array = $mailbox->searchMailBox('SINCE ' . date('d-M-Y', strtotime('-1 day')));
            rsort($mailsIds_array);
            if (count($mailsIds_array) > 0) {
                $mailsIds = array_slice($mailsIds_array, 0, 10);
                foreach ($mailsIds as $mailId) {
                    $this->getMailByid($mailId, $e_mail);
                }
            }
        }
    }
    /**
     * get email by ids
     * @param integer $mailId
     * @param object $e_mail
     */
    public function getMailByid($mailId, $e_mail) {
        $host = $this->host($e_mail);
        $port = $this->port($e_mail);
        $protocol = $this->protocol($e_mail);


        $imap_config = '{' . $host . ':' . $port . $protocol . '}INBOX';

        $password = Crypt::decrypt($e_mail->password);
        $mailbox = new ImapMailbox($imap_config, $e_mail->email_address, $password, __DIR__);

        $overview = $mailbox->get_overview($mailId);
        //dd($overview);
        $var = $overview[0]->seen ? 'read' : 'unread';

        if ($var == 'unread') {
            //dd($overview);
            $mail = $mailbox->getMail($mailId);
            $result = $this->sendWorkflow($mail, $overview, $e_mail);
            if ($result[1] == true) {
                $this->saveThread($mail, $result[0]);
            }
        }
    }
    /**
     * 
     * @param object $mail
     * @param object $overview
     * @param object $e_mail
     * @return array
     */
    public function sendWorkflow($mail, $overview, $e_mail) {
        $settings_email = new Emails();
        $collaborator = null;
        if ($settings_email->first()->email_collaborator == 1) {
            $collaborator = $mail->cc;
        }
        $body = $this->body($mail);
        $date = $this->date($mail, $overview);
        $auto_response = $e_mail->auto_response;
        $priority = $this->priority($e_mail);
        $dept = $this->department($e_mail);
        $helptopic = $this->helptopic($e_mail);
        $sla = $this->sla($e_mail);
        $subject = $this->subject($mail);
        $fromname = $mail->fromName;
        $fromaddress = $mail->fromAddress;
        $ticket_source = Ticket_source::where('name', '=', 'email')->first();
        $source = $ticket_source->id;
        $phone = '';
        $phonecode = '';
        $mobile_number = '';
        $get_helptopic = Help_topic::where('id', '=', $helptopic)->first();
        $assign = $get_helptopic->auto_assign;
        $form_data = null;
        $team_assign = null;
        $ticket_status = null;
        $result = $this->TicketWorkflowController->workflow($fromaddress, $fromname, $subject, $body, $phone, $phonecode, $mobile_number, $helptopic, $sla, $priority, $source, $collaborator, $dept, $assign, $team_assign, $ticket_status, $form_data, $auto_response);
        return $result;
    }
    /**
     * save thread
     * @param object $mail
     * @param string $ticket_number
     */
    public function saveThread($mail, $ticket_number) {
        $ticket_table = Tickets::where('ticket_number', '=', $ticket_number)->first();
        $thread_id = Ticket_Thread::where('ticket_id', '=', $ticket_table->id)->max('id');
        $this->attachment($mail, $thread_id);
        $body = $this->body($mail);
        $thread = Ticket_Thread::where('id', '=', $thread_id)->first();
        $thread->body = $this->separate_reply($body);
        $thread->save();
        Log::info("Ticket has created : ", ['id' => $thread->ticket_id]);
    }

    /**
     * separate reply.
     *
     * @param type $body
     *
     * @return type string
     */
    public function separate_reply($body) {
        $body2 = explode('---Reply above this line---', $body);
        $body3 = $body2[0];

        return $body3;
    }

    /**
     * Decode Imap text.
     *
     * @param type $str
     *
     * @return type string
     */
    public function decode_imap_text($str) {
        $result = '';
        $decode_header = imap_mime_header_decode($str);
        foreach ($decode_header as $obj) {
            $result .= htmlspecialchars(rtrim($obj->text, "\t"));
        }

        return $result;
    }

    /**
     * fetch_attachments.
     *
     * @return type
     */
    public function fetch_attachments() {
        $uploads = Upload::all();
        foreach ($uploads as $attachment) {
            $image = @imagecreatefromstring($attachment->file);
            ob_start();
            imagejpeg($image, null, 80);
            $data = ob_get_contents();
            ob_end_clean();
            $var = '<a href="" target="_blank"><img src="data:image/jpg;base64,' . base64_encode($data) . '"/></a>';
            echo '<br/><span class="mailbox-attachment-icon has-img">' . $var . '</span>';
        }
    }

    /**
     * function to load data.
     *
     * @param type $id
     *
     * @return type file
     */
    public function get_data($id) {
        $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('id', '=', $id)->get();
        foreach ($attachments as $attachment) {
            header('Content-type: application/' . $attachment->type . '');
            header('Content-Disposition: inline; filename=' . $attachment->name . '');
            header('Content-Transfer-Encoding: binary');
            echo $attachment->file;
        }
    }
    /**
     * trim table tag
     * @param string $html
     * @return string
     */
    public static function trimTableTag($html) {
        if (strpos('<table>', $html) != false) {
            $first_pos = strpos($html, '<table');
            $fist_string = substr_replace($html, '', 0, $first_pos);
            $last_pos = strrpos($fist_string, '</table>', -1);
            $total = strlen($fist_string);
            $diff = $total - $last_pos;
            $str = substr_replace($fist_string, '', $last_pos, -1);
            $final_str = str_finish($str, '</table>');

            return $final_str;
        }

        return $html;
    }

    public static function trim3D($html) {
        $body = str_replace('=3D', '', $html);

        return $body;
    }
    /**
     * tring string for purifying html
     * @param string $html
     * @param array $tags
     * @return type
     */
    public static function trimInjections($html, $tags = ['<script>', '</script>', '<style>', '</style>', '<?php', '?>']) {
        $replace = [];
        foreach ($tags as $key => $tag) {
            $replace[$key] = htmlspecialchars($tag);
        }
        $body = str_replace($tags, $replace, $html);

        return $body;
    }
    /**
     * 
     * @param object $email
     * @return string
     */
    public function host($email) {
        return $email->fetching_host;
    }
    /**
     * 
     * @param object $email
     * @return string
     */
    public function port($email) {
        return $email->fetching_port;
    }
    /**
     * 
     * @param object $e_mail
     * @return string
     */
    public function protocol($e_mail) {
        $protocol = "";
        if ($e_mail->mailbox_protocol) {
            $protocol_value = $e_mail->mailbox_protocol;
            $get_mailboxprotocol = MailboxProtocol::where('id', '=', $protocol_value)->first();
            $protocol = $get_mailboxprotocol->value;
        } elseif ($e_mail->fetching_encryption == '/none') {
            $fetching_encryption2 = '/novalidate-cert';
            $protocol = $fetching_encryption2;
        } else {
            if ($e_mail->fetching_protocol) {
                $fetching_protocol = '/' . $e_mail->fetching_protocol;
            } else {
                $fetching_protocol = '';
            }
            if ($e_mail->fetching_encryption) {
                $fetching_encryption = $e_mail->fetching_encryption;
            } else {
                $fetching_encryption = '';
            }
            $protocol = $fetching_protocol . $fetching_encryption;
        }
        return $protocol;
    }
    /**
     * 
     * @param object $email
     * @return integer
     */
    public function priority($email) {
        $priority = $email->priority;
        if (!$priority) {
            $priority = $this->ticketController()->getSystemDefaultPriority();
        }
        return $priority;
    }
    /**
     * get department
     * @param object $email
     * @return integer
     */
    public function department($email) {
        $department = $email->department;
        if (!$department) {
            $department = $this->ticketController()->getSystemDefaultDepartment();
        }
        return $department;
    }
    /**
     * get help topic
     * @param object $email
     * @return integer
     */
    public function helptopic($email) {
        $helptopic = $email->helptopic;
        if (!$helptopic) {
            $helptopic = $this->ticketController()->getSystemDefaultHelpTopic();
        }
        return $helptopic;
    }
    /**
     * get sla
     * @param object $email
     * @return integer
     */
    public function sla($email) {
        $helptopic = $this->helptopic($email);
        $help = Help_topic::where('id', '=', $helptopic)->first();
        if ($help) {
            $sla = $help->sla_plan;
        }
        if (!$sla) {
            $sla = $this->ticketController()->getSystemDefaultSla();
        }
        return $sla;
    }
    /**
     * get ticket controller
     * @return \App\Http\Controllers\Agent\helpdesk\TicketController
     */
    public function ticketController() {
        $PhpMailController = new \App\Http\Controllers\Common\PhpMailController();
        $NotificationController = new \App\Http\Controllers\Common\NotificationController();
        $controller = new TicketController($PhpMailController, $NotificationController);
        return $controller;
    }
    /**
     * 
     * @param object $mail
     * @return string
     */
    public function body($mail) {
        $body = $mail->textHtml;
        if ($body != null) {
            $body = self::trimTableTag($body);
        }
        if ($body == null) {
            $body = $mail->textPlain;
        }
        if ($body == null) {
            $attach = $mail->getAttachments();
            if (is_array($attach)) {
                if (key_exists('html-body', $attach)) {
                    $path = $attach['html-body']->filePath;
                }
                if ($path == null) {
                    if (key_exists('text-body', $attach)) {
                        $path = $attach['text-body']->filePath;
                    }
                }
                if ($path) {
                    $body = file_get_contents($path);
                }
                if ($body) {
                    $body = self::trimTableTag($body);
                } else {
                    $body = "";
                }
            }
        }
        return $body;
    }
    /**
     * 
     * @param object $mail
     * @param object $overview
     * @return string
     */
    public function date($mail, $overview) {
        $date = $mail->date;
        $datetime = $overview[0]->date;
        $date_time = explode(' ', $datetime);
        $date = $date_time[1] . '-' . $date_time[2] . '-' . $date_time[3] . ' ' . $date_time[4];
        $date = date('Y-m-d H:i:s', strtotime($date));
        return $date;
    }
    /**
     * get subject
     * @param object $mail
     * @return string
     */
    public function subject($mail) {
        $subject = 'No Subject';
        if (isset($mail->subject)) {
            $subject = $mail->subject;
        }
        return $subject;
    }
    /**
     * save attachment to faveo
     * @param object $mail
     * @param int $thread_id
     */
    public function attachment($mail, $thread_id) {
        $settings_email = new Email();
        $attachments = $mail->getAttachments();
        if (count($attachments) > 0) {
            foreach ($attachments as $attachment) {
                $support = 'support';

                $dir_img_paths = __DIR__;
                $dir_img_path = explode('/code', $dir_img_paths);

                $filepath = explode('..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public', $attachment->filePath);

                if (array_key_exists(1, $filepath)) {
                    $path = public_path() . $filepath[1];

                    $filesize = filesize($path);
                    $file_data = file_get_contents($path);
                    $ext = pathinfo($attachment->filePath, PATHINFO_EXTENSION);
                    $imageid = $attachment->id;
                    $string = str_replace('-', '', $attachment->name);
                    $filename = explode('src', $attachment->filePath);
                    $filename = str_replace('\\', '', $filename);
                    $body = str_replace('cid:' . $imageid, $filepath[1], $body);
                    $pos = strpos($body, $filepath[1]);
                    if ($pos == false) {
                        if ($settings_email->first()->attachment == 1) {
                            $upload = new Ticket_attachments();
                            $upload->file = $file_data;
                            $upload->thread_id = $thread_id;
                            $upload->name = $filepath[1];
                            $upload->type = $ext;
                            $upload->size = $filesize;
                            $upload->poster = 'ATTACHMENT';
                            $upload->save();
                        }
                    } else {
                        $upload = new Ticket_attachments();
                        $upload->file = $file_data;
                        $upload->thread_id = $thread_id;
                        $upload->name = $filepath[1];
                        $upload->type = $ext;
                        $upload->size = $filesize;
                        $upload->poster = 'INLINE';
                        $upload->save();
                    }
                    unlink($path);
                }
            }
        }
    }

}
