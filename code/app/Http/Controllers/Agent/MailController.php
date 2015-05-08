<?php namespace App\Http\Controllers\Agent;
use App;
use App\Http\Controllers\Agent\TicketController;
use App\Http\Controllers\Controller;
use App\Model\Email\Emails;
use App\Model\Ticket\Ticket_attachments;
use App\Model\Ticket\Ticket_Thread;

/**
 * MailController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class MailController extends Controller {

	/**
	 * @var string
	 */
	public $email = "";

	/**
	 * @var string
	 */
	public $stream = "";

	/**
	 * constructor
	 * Create a new controller instance.
	 * @param type TicketController $TicketController
	 */
	public function __construct(TicketController $TicketController) {
		$this->TicketController = $TicketController;
	}

	/**
	 * Decode Imap text
	 * @param type $str
	 * @return type string
	 */
	function decode_imap_text($str) {
		$result = '';
		$decode_header = imap_mime_header_decode($str);
		foreach ($decode_header AS $obj) {
			$result .= htmlspecialchars(rtrim($obj->text, "\t"));
		}
		return $result;
	}

	/**
	 * get Imap data
	 */
	function getdata() {
		/**
		 * fetching all the emails allowed to
		 * check for mails to read tickets
		 */
		$email = new Emails;
		$mailboxes = $email->get();

		//check for any value in $mailbox
		if (count($mailboxes) >= 0) {
			foreach ($mailboxes as $current_mailbox) {
				//checking for fetching status of the emails
				if ($current_mailbox['fetching_status']) {
					/**
					 *@imap_open requres three arguments for
					 * reading mails in each emails
					 *
					 * 1. Host
					 * 2. email address
					 * 3. password
					 */
					$stream = @imap_open($current_mailbox['fetching_host'], $current_mailbox['email_address'], $current_mailbox['password']);
					/**
					 *	@var $testvar type string
					 */
					$testvar = "";
					// checking for any result in imap_open with value
					if ($stream >= 0) {
						/**
						 * @imap_search requires two arguments to check
						 * from when to check for mails
						 *
						 * 1. result of @imap_open $stream
						 * 2. date in negative
						 */
						$emails = imap_search($stream, 'SINCE ' . date('d-M-Y', strtotime("-1 day")));
						// checking if $emails has received any value
						if ($emails != false) {
							// count for mails
							if (count($emails) >= 0) {
								rsort($emails);
								foreach ($emails as $email_id) {
									/**
									 * @imap_fetch_overview requires three arguments to check
									 * the overview of each mails
									 *
									 * 1. result of @imap_open $stream
									 * 2. emails numbers $emails_id
									 * 3. and a 0 value
									 */
									$overview = imap_fetch_overview($stream, $email_id, 0);
									$var = $overview[0]->seen ? 'read' : 'unread';
									// check for unread messages
									if ($var == 'read') {
										$testvar = 'set';
										/**
										 * fetching overview details fo each mails
										 *
										 * 1. from address
										 * 2. subject
										 * 3. date and time
										 */
										$from = $this->decode_imap_text($overview[0]->from);
										$subject = $this->decode_imap_text($overview[0]->subject);
										$datetime = $overview[0]->date;
										// separate date and time
										$date_time = explode(" ", $datetime);
										$date = $date_time[1] . "-" . $date_time[2] . "-" . $date_time[3] . " " . $date_time[4];

										//=======================================================================
										//  check user
										//=======================================================================
										// $subject = $subject;
										// $match = '/^[[A-Z]{4}-[0-9]{4}-[0-9]{7}]][A-z0-9]$/';
										// if(preg_match($match, $subject))
										// {
										// echo "success";
										// }
										// else
										// {
										// echo "fail";
										// }
										$emailadd = explode('&', $from);
										$username = $emailadd[0];
										$emailadd = substr($emailadd[1], 3);
										$date = date('Y-m-d H:i:s', strtotime($date));
										$system = "Email";
										$phone = "";
										$helptopic = $this->TicketController->default_helptopic();
										$sla = $this->TicketController->default_sla();
										$structure = imap_fetchstructure($stream, $email_id);
										// $image1 = $structure->parts[0]->parts[1]->parameters[0]->value;
										// $image = $structure->parts[1]->parameters[0]->value;
										// echo '<img src="'.$image1.'">';
										// echo '<img src="'.$image.'">';
										// dd($structure);

										/**
										 *	There are 5 types of mail readable formats
										 *
										 * 1. Html
										 * 2. Alternative
										 * 3. Related
										 * 4. Mixed
										 */

										// checking if the format is Html
										if ($structure->subtype == 'HTML') {
											$body2 = imap_fetchbody($stream, $email_id, 1);
											if ($body2 == null) {
												$body2 = imap_fetchbody($stream, $email_id, 1);
											}
											$body = quoted_printable_decode($body2);
											// $body = explode("---Reply above this line---", $body);
											// echo $body;
											// echo "0";
										}
										// checking if the format is Alternative
										if ($structure->subtype == 'ALTERNATIVE') {
											if (isset($structure->parts)) {
												$body2 = imap_fetchbody($stream, $email_id, 1.2);
												if ($body2 == null) {
													$body2 = imap_fetchbody($stream, $email_id, 1);
												}
												$body = quoted_printable_decode($body2);
												// $body = explode("---Reply above this line---", $body);
												// echo $body[0];
											}
										}
										// checking if the format is related
										if ($structure->subtype == 'RELATED') {
											if (isset($structure->parts)) {
												$parts = $structure->parts;
												$i = 0;
												$body2 = imap_fetchbody($stream, $email_id, 1.2);
												if ($body2 == null) {
													$body2 = imap_fetchbody($stream, $email_id, 1);
												}
												$body = quoted_printable_decode($body2);
												foreach ($parts as $part) {
													if ($parts[$i]) {
													}
													$i++;
													if (isset($parts[$i])) {
														if ($parts[$i]->ifid == 1) {
															$id = $parts[$i]->id;
															$imageid = substr($id, 1, -1);
															$imageid = "cid:" . $imageid;
															if ($parts[$i]->ifdparameters == 1) {
																foreach ($parts[$i]->dparameters as $object) {
																	if (strtolower($object->attribute) == 'filename') {
																		$filename = $object->value;
																	}
																}
															}
															if ($parts[$i]->ifparameters == 1) {
																foreach ($parts[$i]->parameters as $object) {
																	if (strtolower($object->attribute) == 'name') {
																		$name = $object->value;
																	}
																}
															}
															$body = str_replace($imageid, $filename, $body);

															// $ticket_Thread				=	 new Ticket_attachments;
															// // $ticket_Thread->thread_id  	=    $thread_id;
															// $ticket_Thread->name 		=    $filename;
															// // $ticket_Thread->size 		=    $filesize;
															// // $ticket_Thread->type 		=    $ext;
															// $ticket_Thread->content 	=    '<img src="'.$name.'">';
															// $ticket_Thread->save();
															// 	// $body = explode("---Reply above this line---", $body);
															// echo $body[0];
															// echo "2";
														}
													}
												}
											}
										}
										//checking if the format is mixed
										elseif ($structure->subtype == 'MIXED') {
											if (isset($structure->parts)) {
												$parts = $structure->parts;

												// subtype = ALTERNATIVE
												if ($parts[0]->subtype == 'ALTERNATIVE') {
													if (isset($structure->parts)) {
														$body2 = imap_fetchbody($stream, $email_id, 1.2);
														if ($body2 == null) {
															$body2 = imap_fetchbody($stream, $email_id, 1);
														}
														$body = quoted_printable_decode($body2);
													}
												}
												// subtype = RELATED
												if ($parts[0]->subtype == 'RELATED') {
													if (isset($parts[0]->parts)) {
														$parts = $parts[0]->parts;
														$i = 0;

														$body2 = imap_fetchbody($stream, $email_id, 1.1);
														if ($body2 == null) {
															$body2 = imap_fetchbody($stream, $email_id, 1);
														}
														$body = quoted_printable_decode($body2);
														$name = "";
														foreach ($parts as $part) {
															if ($parts[0]) {
															}
															$i++;
															if (isset($parts[$i])) {
																if ($parts[$i]->ifid == 1) {
																	$id = $parts[$i]->id;
																	$imageid = substr($id, 1, -1);
																	$imageid = "cid:" . $imageid;
																	if ($parts[$i]->ifdparameters == 1) {
																		foreach ($parts[$i]->dparameters as $object) {
																			if (strtolower($object->attribute) == 'filename') {
																				$filename = $object->value;
																			}
																		}
																	}
																	if ($parts[$i]->ifparameters == 1) {
																		foreach ($parts[$i]->parameters as $object) {
																			if (strtolower($object->attribute) == 'name') {
																				$name = $object->value;
																			}
																		}
																	}
																}
																$body = str_replace($imageid, $name, $body);
																// $body = explode("---Reply above this line---", $body);
																// echo $body[0];
																// echo '3'
															}
														}
													}
												}
											}
											// dd($structure);
										}
										// $ticket 		     	=	 new Tickets;
										// $ticket->name 	    =    $from;
										// $ticket->subject     =    $subject;
										// $ticket->body        =    $body2;
										// $ticket->date        =    $datetime;
										// $ticket->save();
										// $ticket 		     	=	 new Ticket_Thread;
										// $ticket->name 		=    $from;
										// $ticket->subject 	=    $subject;
										// $ticket->body 	    =    $body2;
										// $ticket->date 	    =    $datetime;
										// $ticket->save();
										$priority = '1';
										if ($this->TicketController->create_user($emailadd, $username, $subject, $body, $phone, $helptopic, $sla, $priority, $system) == true) {
											$thread_id = Ticket_Thread::whereRaw('id = (select max(`id`) from ticket_thread)')->first();
											$thread_id = $thread_id->id;
											if ($this->get_attachment($structure, $stream, $email_id, $thread_id) == true) {

											}
										}
									} else {

									}
								}
							}
						}
						imap_close($stream);
					}
				}
			}
		}
	}

	/**
	 * Get attachments data from mail
	 * @param type $structure
	 * @param type $stream
	 * @param type $email_id
	 * @param type $thread_id
	 * @return type bool
	 */
	public function get_attachment($structure, $stream, $email_id, $thread_id) {
		// checking if the mails has attachments
		if (isset($structure->parts) && count($structure->parts)) {
			for ($i = 0; $i < count($structure->parts); $i++) {
				$attachments[$i] = array(
					'is_attachment' => false,
					'filename' => '',
					'name' => '',
					'attachment' => '');
				// checking for files
				if ($structure->parts[$i]->ifdparameters) {
					foreach ($structure->parts[$i]->dparameters as $object) {
						if (strtolower($object->attribute) == 'filename') {
							$attachments[$i]['is_attachment'] = true;
							$attachments[$i]['filename'] = $object->value;
						}
					}
				}
				// checking for files
				if ($structure->parts[$i]->ifparameters) {
					foreach ($structure->parts[$i]->parameters as $object) {
						if (strtolower($object->attribute) == 'name') {
							$attachments[$i]['is_attachment'] = true;
							$attachments[$i]['name'] = $object->value;
						}
					}
				}
				/**
				 *	All over again checking for the availability of attachment
				 */
				if ($attachments[$i]['is_attachment']) {
					$attachments[$i]['attachment'] = imap_fetchbody($stream, $email_id, $i + 1);
					// decoding if encoded in base64_encode format else quoted_printable_encode
					if ($structure->parts[$i]->encoding == 3) {
						$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
					} elseif ($structure->parts[$i]->encoding == 4) {
						$attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
					}
				}
			}
			// calling the save method to save each attachments
			if ($this->save_attcahments($attachments, $thread_id) == true) {
				return true;
			}
		}
	}

	/**
	 * Function to save attachments
	 * @param type $attachments
	 * @param type $thread_id
	 * @return type bool
	 */
	public function save_attcahments($attachments, $thread_id) {
		if (count($attachments) != 0) {
			foreach ($attachments as $at) {
				if ($at['is_attachment'] == 1) {
					$str = str_shuffle('abcdefghijjklmopqrstuvwxyz');
					$filename = $at['filename'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$tmpName = $at['filename'];
					$fp = fopen($tmpName, 'r');
					$content = fread($fp, filesize($tmpName));
					$content2 = file_put_contents($at['filename'], $at['attachment']);
					$filesize = $content2;
					$ticket_Thread = new Ticket_attachments;
					$ticket_Thread->thread_id = $thread_id;
					$ticket_Thread->name = $filename;
					$ticket_Thread->size = $filesize;
					$ticket_Thread->type = $ext;
					$ticket_Thread->content = $fp;
					$ticket_Thread->save();
				}
			}
		}
		return true;
	}
}
