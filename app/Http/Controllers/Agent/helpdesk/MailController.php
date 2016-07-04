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
use PhpImap\Mailbox as ImapMailbox;

/**
 * MailController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class MailController extends Controller
{
    /**
     * constructor
     * Create a new controller instance.
     *
     * @param type TicketController $TicketController
     */
    public function __construct(TicketWorkflowController $TicketWorkflowController)
    {
        $this->middleware('board');
        $this->TicketWorkflowController = $TicketWorkflowController;
    }

    /**
     * Reademails.
     *
     * @return type
     */
    public function readmails(Emails $emails, Email $settings_email, System $system, Ticket $ticket)
    {
        // $path_url = $system->first()->url;
        if ($settings_email->first()->email_fetching == 1) {
            if ($settings_email->first()->all_emails == 1) {
                // $helptopic = $this->TicketController->default_helptopic();
                // $sla = $this->TicketController->default_sla();
                $email = $emails->get();
                foreach ($email as $e_mail) {
                    if ($e_mail->fetching_status == 1) {
                        $auto_response = $e_mail->auto_response;
                        $priority = $e_mail->priority;
                        $dept = $e_mail->department;
                        $helptopic = $e_mail->help_topic;
                        if ($priority == null) {
                            $priority = $ticket->first()->priority;
                        }
                        if ($dept == null) {
                            $dept = $system->first()->department;
                        }
                        if ($helptopic == null) {
                            $helptopic = $ticket->first()->help_topic;
                        }
                        $get_helptopic = Help_topic::where('id', '=', $helptopic)->first();
                        $sla = $get_helptopic->sla_plan;
                        $host = $e_mail->fetching_host;
                        $port = $e_mail->fetching_port;
                        if ($e_mail->mailbox_protocol) {
                            $protocol_value = $e_mail->mailbox_protocol;
                            $get_mailboxprotocol = MailboxProtocol::where('id', '=', $protocol_value)->first();
                            $protocol = $get_mailboxprotocol->value;
                        } elseif ($e_mail->fetching_encryption == '/none') {
                            $fetching_encryption2 = '/novalidate-cert';
                            $protocol = $fetching_encryption2;
                        } else {
                            if ($e_mail->fetching_protocol) {
                                $fetching_protocol = '/'.$e_mail->fetching_protocol;
                            } else {
                                $fetching_protocol = '';
                            }
                            if ($e_mail->fetching_encryption) {
                                $fetching_encryption = $e_mail->fetching_encryption;
                            } else {
                                $fetching_encryption = '';
                            }
                            $protocol = $fetching_protocol.$fetching_encryption;
                        }
                        $imap_config = '{'.$host.':'.$port.$protocol.'}INBOX';
                        $password = Crypt::decrypt($e_mail->password);
                        try {
                            $mailbox = new ImapMailbox($imap_config, $e_mail->email_address, $password, __DIR__);
                        } catch (\PhpImap\Exception $e) {
                            echo "Connection error";
                        }
                        $mails = [];
                        try {
                            $mailsIds = $mailbox->searchMailBox('SINCE '.date('d-M-Y', strtotime('-1 day')));
                        } catch (\PhpImap\Exception $e) {
                            echo "Connection error";
                        }
                        if (!$mailsIds) {
                            die('Mailbox is empty');
                        }
                        foreach ($mailsIds as $mailId) {
                            try {
                                $overview = $mailbox->get_overview($mailId);
                            } catch (Exception $e) {
                                return \Lang::get('lang.unable_to_fetch_emails');
                            }
                            $var = $overview[0]->seen ? 'read' : 'unread';
                            if ($var == 'unread') {
                                $mail = $mailbox->getMail($mailId);
                                try {
                                    $mail = $mailbox->getMail($mailId);
                                } catch (\PhpImap\Exception $e) {
                                    echo "Connection error";
                                }
                                if ($settings_email->first()->email_collaborator == 1) {
                                    $collaborator = $mail->cc;
                                } else {
                                    $collaborator = null;
                                }
                                $body = $mail->textHtml;
                                if ($body != null) {
                                    $body = self::trimTableTag($body);
                                }
                                // if mail body has no messages fetch backup mail
                                if ($body == null) {
                                    $body = $mail->textPlain;
                                }
                                if ($body == null) {
                                    $attach = $mail->getAttachments();
                                    $path = $attach['html-body']->filePath;
                                    if ($path == null) {
                                        $path = $attach['text-body']->filePath;
                                    }

                                    $body = file_get_contents($path);
                                    //dd($body);
                                    $body = self::trimTableTag($body);
                                }
//                                if ($body == null) {
//                                    $body = $mailbox->backup_getmail($mailId);
//                                    $body = str_replace('\r\n', '<br/>', $body);
//                                }
                                $date = $mail->date;
                                $datetime = $overview[0]->date;
                                $date_time = explode(' ', $datetime);
                                $date = $date_time[1].'-'.$date_time[2].'-'.$date_time[3].' '.$date_time[4];
                                $date = date('Y-m-d H:i:s', strtotime($date));
                                if (isset($mail->subject)) {
                                    $subject = utf8_decode($mail->subject);
                                } else {
                                    $subject = 'No Subject';
                                }
                                $fromname = $mail->fromName;
                                $fromaddress = $mail->fromAddress;
                                $ticket_source = Ticket_source::where('name', '=', 'email')->first();
                                $source = $ticket_source->id;
                                $phone = '';
                                $phonecode = '';
                                $mobile_number = '';
                                $assign = $get_helptopic->auto_assign;
                                $form_data = null;
                                $team_assign = null;
                                $ticket_status = null;
                                $result = $this->TicketWorkflowController->workflow($fromaddress, $fromname, $subject, $body, $phone, $phonecode, $mobile_number, $helptopic, $sla, $priority, $source, $collaborator, $dept, $assign, $team_assign, $ticket_status, $form_data, $auto_response);
// dd($result);
                                if ($result[1] == true) {
                                    $ticket_table = Tickets::where('ticket_number', '=', $result[0])->first();
                                    $thread_id = Ticket_Thread::where('ticket_id', '=', $ticket_table->id)->max('id');
// $thread_id = Ticket_Thread::whereRaw('id = (select max(`id`) from ticket_thread)')->first();
                                    $thread_id = $thread_id;
                                    foreach ($mail->getAttachments() as $attachment) {
                                        $support = 'support';
// echo $_SERVER['DOCUMENT_ROOT'];
                                        $dir_img_paths = __DIR__;
                                        $dir_img_path = explode('/code', $dir_img_paths);
// dd($attachment->filePath);
                                        $filepath = explode('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'public', $attachment->filePath);
// var_dump($attachment->filePath);
// dd($filepath);
// $path = $dir_img_path[0]."/code/public/".$filepath[1];
                                        $path = public_path().$filepath[1];
// dd($path);
                                        $filesize = filesize($path);
                                        $file_data = file_get_contents($path);
                                        $ext = pathinfo($attachment->filePath, PATHINFO_EXTENSION);
                                        $imageid = $attachment->id;
                                        $string = str_replace('-', '', $attachment->name);
                                        $filename = explode('src', $attachment->filePath);
                                        $filename = str_replace('\\', '', $filename);
                                        $body = str_replace('cid:'.$imageid, $filepath[1], $body);
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
                                    $body = Encoding::fixUTF8($body);
                                    $thread = Ticket_Thread::where('id', '=', $thread_id)->first();
                                    $thread->body = $this->separate_reply($body);
                                    $thread->save();
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * separate reply.
     *
     * @param type $body
     *
     * @return type string
     */
    public function separate_reply($body)
    {
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
    public function decode_imap_text($str)
    {
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
    public function fetch_attachments()
    {
        $uploads = Upload::all();
        foreach ($uploads as $attachment) {
            $image = @imagecreatefromstring($attachment->file);
            ob_start();
            imagejpeg($image, null, 80);
            $data = ob_get_contents();
            ob_end_clean();
            $var = '<a href="" target="_blank"><img src="data:image/jpg;base64,'.base64_encode($data).'"/></a>';
            echo '<br/><span class="mailbox-attachment-icon has-img">'.$var.'</span>';
        }
    }

    /**
     * function to load data.
     *
     * @param type $id
     *
     * @return type file
     */
    public function get_data($id)
    {
        $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('id', '=', $id)->get();
        foreach ($attachments as $attachment) {
            header('Content-type: application/'.$attachment->type.'');
            header('Content-Disposition: inline; filename='.$attachment->name.'');
            header('Content-Transfer-Encoding: binary');
            echo $attachment->file;
        }
    }

    public static function trimTableTag($html)
    {
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

    public static function trim3D($html)
    {
        $body = str_replace('=3D', '', $html);

        return $body;
    }

    public static function trimInjections($html, $tags = ['<script>', '</script>', '<style>', '</style>', '<?php', '?>'])
    {
        $replace = [];
        foreach ($tags as $key => $tag) {
            $replace[$key] = htmlspecialchars($tag);
        }
        $body = str_replace($tags, $replace, $html);

        return $body;
    }
}
