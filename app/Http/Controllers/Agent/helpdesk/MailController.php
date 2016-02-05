<?php namespace App\Http\Controllers\Agent\helpdesk;
// controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Agent\helpdesk\TicketController;

// models
use App\User;
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Settings\Email;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Utility\MailboxProtocol;
use App\Model\helpdesk\Ticket\Ticket_source;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Ticket\Tickets;

// classes
use PhpImap\Mailbox as ImapMailbox;
use PhpImap\IncomingMail;
use PhpImap\IncomingMailAttachment;
use ForceUTF8\Encoding;
use App;
use DB;
use Crypt;
use Schedule;
use File;
use Artisan;
use Exception;
use Phpmailer\PHPMailerautoload;
//$root = realpath($_SERVER["DOCUMENT_ROOT"]);
//include_once($root.'\vendor\phpmailer\phpmailer\PHPMailerautoload.php');
/**
 * MailController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class MailController extends Controller {

	/**
	 * constructor
	 * Create a new controller instance.
	 * @param type TicketController $TicketController
	 */
	public function __construct(TicketController $TicketController) {
		$this->TicketController = $TicketController;
	}

	/**
	 * Reademails
	 * @return type
	 */
        
	
	public function readmails(Emails $emails, Email $settings_email, System $system)
	{
		// $path_url = $system->first()->url;
		if($settings_email->first()->email_fetching == 1)
		{
		if($settings_email->first()->all_emails == 1)
		{
		// $helptopic = $this->TicketController->default_helptopic();
		// $sla = $this->TicketController->default_sla();
		$email = $emails->get();
		foreach($email as $e_mail) 
		{
			$helptopic = $e_mail->help_topic;
			$get_helptopic = Help_topic::where('id', '=', $helptopic)->first();
			$sla  = $get_helptopic->sla_plan;
			$dept = $e_mail->department;
			$host = $e_mail->fetching_host;
			$port = $e_mail->fetching_port;
			$protocol = $e_mail->mailbox_protocol;
			$get_mailboxprotocol = MailboxProtocol::where('id','=',$protocol)->first();
			$protocol = $get_mailboxprotocol->value;
			$imap_config = '{'.$host.':'.$port.$protocol.'}INBOX';
			$password = Crypt::decrypt($e_mail->password);
			$mailbox = new ImapMailbox($imap_config, $e_mail->email_address, $password, __DIR__);
			$mails = array();
			$mailsIds = $mailbox->searchMailBox('SINCE '. date('d-M-Y', strtotime("-1 day")));
			if(!$mailsIds) {
			    die('Mailbox is empty');
			}
			foreach($mailsIds as $mailId) {
				$overview = $mailbox->get_overview($mailId);	
				$var = $overview[0]->seen ? 'read' : 'unread';
				if ($var == 'unread') {
					$mail = $mailbox->getMail($mailId);
					if($settings_email->first()->email_collaborator == 1) {
						$collaborator = $mail->cc;
					} else {
						$collaborator = null;
					}
					$body = $mail->textHtml;
					if($body == null) {
						$body = $mailbox->backup_getmail($mailId);
						$body = str_replace('\r\n', '<br/>', $body);
						// var_dump($body);
					}
					$date = $mail->date; 
	     			$datetime = $overview[0]->date;
					$date_time = explode(" ", $datetime);
					$date = $date_time[1] . "-" . $date_time[2] . "-" . $date_time[3] . " " . $date_time[4];
					$date = date('Y-m-d H:i:s', strtotime($date));
					// dd($date);
					
					if(isset($mail->subject)){
						$subject = $mail->subject;
					} else {
						$subject = "No Subject";
					}
					
					// dd($subject);
					$fromname = $mail->fromName;
					$fromaddress = $mail->fromAddress;
					$ticket_source = Ticket_source::where('name','=','email')->first();
					$source = $ticket_source->id;
					$phone = "";
					$priority = $get_helptopic->priority;
					// Ticket_Priority::where('')

					$assign = $get_helptopic->auto_assign; 
					$form_data = null;
					$result = $this->TicketController->create_user($fromaddress, $fromname, $subject, $body, $phone, $helptopic, $sla, $priority, $source, $collaborator, $dept, $assign, $form_data);
					// dd($result);
					if ($result[1] == true) {
							$ticket_table = Tickets::where('ticket_number', '=' , $result[0])->first();
							$thread_id = Ticket_Thread::where('ticket_id','=',$ticket_table->id)->max('id');
							// $thread_id = Ticket_Thread::whereRaw('id = (select max(`id`) from ticket_thread)')->first();
							$thread_id = $thread_id;
					
						foreach($mail->getAttachments() as $attachment) {
							$support = "support";
							// echo $_SERVER['DOCUMENT_ROOT'];
							$dir_img_paths = __DIR__;
							$dir_img_path = explode('/code', $dir_img_paths);
							// dd($attachment->filePath);
							$filepath = explode('../../../../../public',$attachment->filePath);
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
							$body = str_replace("cid:".$imageid, $filepath[1], $body);	
							$pos = strpos($body, $filepath[1]);

							if($pos == false) {
                                if($settings_email->first()->attachment == 1) {
		     				        $upload = new Ticket_attachments;
                					$upload->file = $file_data;
               						$upload->thread_id = $thread_id;
		        					$upload->name = $filepath[1];
			        				$upload->type = $ext;
				         			$upload->size = $filesize;
					         		$upload->poster = "ATTACHMENT";
						         	$upload->save();
                                }
							} else {
							$upload = new Ticket_attachments;
							$upload->file = $file_data;
							$upload->thread_id = $thread_id;
							$upload->name = $filepath[1];
							$upload->type = $ext;
							$upload->size = $filesize;
							$upload->poster = "INLINE";
							$upload->save();
							}
							unlink($path);
						}
						$body = Encoding::fixUTF8($body);
						$thread = Ticket_Thread::where('id','=',$thread_id)->first();
						$thread->body = $this->separate_reply($body)	;
						$thread->save();
					}
				}
			}
		}
		}
		}
	}

	/**
	 * separate reply
	 * @param type $body 
	 * @return type string
	 */
	public function separate_reply($body) {
		$body2 = explode('---Reply above this line---', $body);
		$body3 = $body2[0];
		return $body3; 
	}

	/**
	 * Decode Imap text
	 * @param type $str
	 * @return type string
	 */
	public function decode_imap_text($str) {
		$result = '';
		$decode_header = imap_mime_header_decode($str);
		foreach ($decode_header AS $obj) {
			$result .= htmlspecialchars(rtrim($obj->text, "\t"));
		}
		return $result;
	}

	/**
	 * fetch_attachments
	 * @return type
	 */
	public function fetch_attachments(){
		$uploads = Upload::all();
		foreach($uploads as $attachment) {
			$image = @imagecreatefromstring($attachment->file); 
	        ob_start();
	        imagejpeg($image, null, 80);
	        $data = ob_get_contents();
	        ob_end_clean();
	        $var = '<a href="" target="_blank"><img src="data:image/jpg;base64,' . base64_encode($data)  . '"/></a>';
	        echo '<br/><span class="mailbox-attachment-icon has-img">'.$var.'</span>';
	    }
	}

	/**
	 * function to load data
	 * @param type $id 
	 * @return type file
	 */
	public function get_data($id){
		$attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('id','=',$id)->get();
		foreach($attachments as $attachment)
		{
    			header('Content-type: application/'.$attachment->type.'');
				header('Content-Disposition: inline; filename='.$attachment->name.'');
				header('Content-Transfer-Encoding: binary');
				echo $attachment->file;
    	}
	}

}
