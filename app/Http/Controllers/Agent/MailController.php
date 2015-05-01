<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
// use App\Model\Ticket\Ticket;
use App\Model\Email\Emails;
use App\Model\Ticket\Ticket_attachments;
use App\Model\Ticket\Ticket_Thread;

class MailController extends Controller {

	public $email = "";
	public $stream = "";

	// public function fetchEmails(Emails $email)
	// {
	// 	$emails = $email->get();
	// 	$mailboxes = $emails;
	// 	return $mailboxes;
	// }

	function decode_imap_text($str) {
		$result = '';
		$decode_header = imap_mime_header_decode($str);
		foreach ($decode_header AS $obj) {
			$result .= htmlspecialchars(rtrim($obj->text, "\t"));
		}
		return $result;
	}

	function getdata() {
		$email = new Emails;
		$mailboxes = $email->get();

		if (count($mailboxes) >= 0) {
			foreach ($mailboxes as $current_mailbox) {
				if ($current_mailbox['fetching_status']) {
					$stream = @imap_open($current_mailbox['fetching_host'], $current_mailbox['email_address'], $current_mailbox['password']);
					$testvar = "";
					if ($stream >= 0) {
						$emails = imap_search($stream, 'SINCE ' . date('d-M-Y', strtotime("-10 day")));
						if ($emails != false) {
							if (count($emails) >= 0) {
								rsort($emails);
								foreach ($emails as $email_id) {
									$overview = imap_fetch_overview($stream, $email_id, 0);
									$var = $overview[0]->seen ? 'read' : 'unread';
									if ($var == 'unread') {
										$testvar = 'set';

										$from = $this->decode_imap_text($overview[0]->from);
										$subject = $this->decode_imap_text($overview[0]->subject);
										$datetime = $overview[0]->date;
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
										$helptopic = $this->default_helptopic();
										$sla = $this->default_sla();

										$structure = imap_fetchstructure($stream, $email_id);
										// $image1 = $structure->parts[0]->parts[1]->parameters[0]->value;
										// $image = $structure->parts[1]->parameters[0]->value;
										// echo '<img src="'.$image1.'">';
										// echo '<img src="'.$image.'">';
										// dd($structure);
										//=================================================
										//  HTML
										//=================================================
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

										//=================================================
										//  ALTERNATIVE
										//=================================================
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

										//=================================================
										//  RELATED
										//=================================================
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

										//=================================================
										//  MIXED
										//=================================================
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

										if ($this->create_user($emailadd, $username, $subject, $body, $phone, $helptopic, $sla, $system) == true) {
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

	//======================================
	//	ATTACHMENT   			|Incomplete
	//======================================
	public function get_attachment($structure, $stream, $email_id, $thread_id) {
		if (isset($structure->parts) && count($structure->parts)) {
			for ($i = 0; $i < count($structure->parts); $i++) {
				$attachments[$i] = array(
					'is_attachment' => false,
					'filename' => '',
					'name' => '',
					'attachment' => '');

				if ($structure->parts[$i]->ifdparameters) {
					foreach ($structure->parts[$i]->dparameters as $object) {
						if (strtolower($object->attribute) == 'filename') {
							$attachments[$i]['is_attachment'] = true;
							$attachments[$i]['filename'] = $object->value;
						}
					}
				}
				if ($structure->parts[$i]->ifparameters) {
					foreach ($structure->parts[$i]->parameters as $object) {
						if (strtolower($object->attribute) == 'name') {
							$attachments[$i]['is_attachment'] = true;
							$attachments[$i]['name'] = $object->value;
						}
					}
				}
				if ($attachments[$i]['is_attachment']) {
					$attachments[$i]['attachment'] = imap_fetchbody($stream, $email_id, $i + 1);
					if ($structure->parts[$i]->encoding == 3) {
						$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
					} elseif ($structure->parts[$i]->encoding == 4) {
						$attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
					}
				}
			}
			if ($this->save_attcahments($attachments, $thread_id) == true) {
				return true;
			}
		}
	}

	//=====================================
	//	SAVE ATTACHMENT        | Incomplete
	//=====================================
	public function save_attcahments($attachments, $thread_id) {
		if (count($attachments) != 0) {
			foreach ($attachments as $at) {
				if ($at['is_attachment'] == 1) {
					$str = str_shuffle('abcdefghijjklmopqrstuvwxyz');
					$filename = $at['filename'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$tmpName = $at['filename'];
					// echo '<img src="'.$tmpName.'">';
					$fp = fopen($tmpName, 'r');
					$content = fread($fp, filesize($tmpName));
					$content2 = file_put_contents($at['filename'], $at['attachment']);
					$filesize = $content2;
					$ticket_Thread = new Ticket_attachments;
					$ticket_Thread->thread_id = $thread_id;
					$ticket_Thread->name = $filename;
					$ticket_Thread->size = $filesize;
					$ticket_Thread->type = $ext;
					$ticket_Thread->content = $fp; //$content;
					$ticket_Thread->save();
				}
			}
		}
		return true;
	}

	// // public function part($part)
	// // {
	// // 	$structure = $part->parts;
	// // 	return $structure;
	// // }
	// // public function fetchdata()
	// // {
	// // 	$tickets = Tickets::all();
	// // 	foreach ($tickets as $ticket)
	// // 	{
	// // 		echo $ticket->body.'<hr/>';
	// // 	}
	// // }
	// public function ticket_list()
	// {
	// 	$tickets = Tickets::all();
	// 	$threads = Ticket_Thread::all();
	// 	return view('themes.default1.agent.ticket.ticket',compact('tickets'),compact('threads'));
	// }
	// public function thread($id)
	// {
	// 	$tickets = Tickets::where('id','=',$id)->first();
	// 	$thread = Ticket_Thread::where('ticket_id','=',$id)->first();
	// 	return view('themes.default1.agent.ticket.timeline',compact('tickets'),compact('thread'));
	// }
	// //============================================
	// //  Create Ticket 			      | Incomplete
	// //============================================
	// public function reply(Ticket_Thread $thread, TicketRequest $request)
	// {
	// 	$thread->ticket_id = $request->input('ticket_ID');
	// 	$thread->title = $request->input('To');
	// 	$thread->body = $request->input('ReplyContent');
	// 	$thread->save();
	// 	$ticket_id = $request->input('ticket_ID');
	// 	$tickets = Tickets::where('id','=',$ticket_id)->first();
	// 	$thread = Ticket_Thread::where('ticket_id','=',$ticket_id)->first();
	// 	// return 'success';
	// 	return  Redirect("thread/".$ticket_id);
	// }
	// //============================================
	// //  Ticket Edit get			      | Incomplete
	// //============================================
	// public function ticket_edit_get($id, Tickets $ticket , Ticket_Thread $thread)
	// {
	// 	$ticket_id = $ticket->where('id' , '=' , $id)->first();
	// 	$thread_id = $thread->where('ticket_id' , '=' , $id)->first();
	// 	$user = User::where('id' , '=' , $ticket_id->user_id)->first();
	// 	return  view("themes.default1.agent.ticket.edit",compact('ticket_id','thread_id','user'));
	// }
	// //============================================
	// //  Ticket Edit post 			      | Incomplete
	// //============================================
	// public function ticket_edit_post($ticket_id,Ticket_Thread $thread)
	// {
	// 	dd($ticket_id);
	// 	// return  Redirect("");
	// }
	// //============================================
	// //  Ticket print  			      | Incomplete
	// //============================================
	// public function ticket_print($id)
	// {
	// 	return pdf();
	// 	// return  Redirect("");
	// }
	// //============================================
	// //  Generate Ticket Number        | Incomplete
	// //============================================
	// public function ticket_number($ticket_number)
	// {
	// 	$number = $ticket_number;
	// 	$number = explode('-',$number);
	// 	$number1 = $number[0];
	// 	if($number1 == 'ZZZZ'){
	// 		$number1 = 'AAAA';
	// 	}
	// 	$number2 = $number[1];
	// 	if($number2 == '9999'){
	// 		$number2 = '0000';
	// 	}
	// 	$number3 = $number[2];
	// 	if($number3 == '9999999'){
	// 		$number3 = '0000000';
	// 	}
	// 	$number1++;
	// 	$number2++;
	// 	$number3++;
	// 	$number2 = sprintf('%04s', $number2);
	// 	$number3 = sprintf('%07s', $number3);
	// 	$array = array($number1,$number2,$number3);
	// 	$number = implode('-', $array);
	// 	return $number;
	// }
	// //=============================================
	// //	Checking email availability      | Complete
	// //=============================================
	// public function check_email($email)
	// {
	// 	$check = User::where('email','=',$email)->first();
	// 	if($check == true)
	// 	{
	// 		return $check;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }
	// //===============================================
	// //	Create User  					|  InComplete
	// //===============================================
	// public function create_user($emailadd, $username, $subject, $body, $phone, $helptopic, $sla, $system)
	// {
	// 	$email;
	// 	$username;
	// 	$checkemail = $this->check_email($emailadd);
	// 	if($checkemail == false )
	// 	{
	// 		$password = $this->generateRandomString();
	// 		$user = new User;
	// 		$user->user_name	=	$username;
	// 		$user->email   		=	$emailadd;
	// 		$user->password 	=	Hash::make($password);
	// 		if($user->save())
	// 		{
	// 			$user_id = $user->id;
	// 			if(Mail::send('emails.pass', ['password' => $password, 'name' => $username],
	// 				function($message)use($emailadd, $username)
	// 					{
	//    						$message->to($emailadd, $username)->subject('password');
	// 					}))
	// 					{
	// 					}
	// 		}
	// 	}
	// 	else
	// 	{
	// 		$username = $checkemail->username;
	// 		$user_id = $checkemail->id;
	// 	}
	// 	$ticket_number = $this->check_ticket($user_id, $subject, $body, $helptopic, $sla);
	// 	if(Mail::send('emails.Ticket_Create', ['name' => $username, 'ticket_number' => $ticket_number],
	// 			function($message)use($emailadd, $username, $ticket_number)
	// 			{
	//    				$message->to($emailadd, $username)->subject('[~'.$ticket_number.']');
	// 			}))
	// 		{
	// 			return true;
	// 		}
	// }
	// //============================================
	// //  Select Default help_topic     | Incomplete
	// //============================================
	// public function default_helptopic()
	// {
	// 	$helptopic = "Support";
	// 	return $helptopic;
	// }
	// //============================================
	// //  Select Default sla 			  | Incomplete
	// //============================================
	// public function default_sla()
	// {
	// 	$sla = "12hours";
	// 	return $sla;
	// }
	// //============================================
	// //  Select Default priority       | Incomplete
	// //============================================
	// public function default_priority()
	// {
	// 	$priority = "important";
	// 	return $helptopic;
	// }
	// //============================================
	// //  check ticket 				  | Incomplete
	// //============================================
	// public function check_ticket($user_id, $subject, $body, $helptopic, $sla)
	// {
	// 	$read_ticket_number = substr($subject, 0, 6);
	// 	if($read_ticket_number == 'Re: [~')
	// 	{
	// 		$separate = explode("]", $subject);
	// 		$new_subject = substr($separate[0] , 6 , 20);
	// 		$find_number = Tickets::where('ticket_number', '=', $new_subject)->first();
	// 		$thread_body = explode("---Reply above this line---", $body);
	// 		$body = $thread_body[0];
	// 		if(count($find_number) > 0)
	// 		{
	// 			$id = $find_number->id;
	// 			$ticket_number = $find_number->ticket_number;
	// 			if(isset($id))
	// 			{
	// 				if($this->ticket_thread($subject, $body, $id, $user_id))
	// 				{
	// 				return $ticket_number;
	// 				}
	// 			}
	// 		}
	// 		else
	// 		{
	// 			$ticket_number = $this->create_ticket($user_id, $subject, $body, $helptopic, $sla);
	// 			return $ticket_number;
	// 		}
	// 	}
	// 	else
	// 	{
	// 		$ticket_number = $this->create_ticket($user_id, $subject, $body, $helptopic, $sla);
	// 		return $ticket_number;
	// 	}
	// }
	// //============================================
	// //  Create Ticket 			      | Incomplete
	// //============================================
	// public function create_ticket($user_id, $subject, $body, $helptopic, $sla)
	// {
	// 	$max_number = Tickets::whereRaw('id = (select max(`id`) from tickets)')->get();
	// 	foreach($max_number as $number)
	// 	{
	// 		$ticket_number = $number->ticket_number;
	// 	}
	// 	$ticket = new Tickets;
	// 	$ticket->ticket_number = $this->ticket_number($ticket_number);
	// 	$ticket->user_id = $user_id;
	// 	$ticket->save();
	// 	$ticket_number = $ticket->ticket_number;
	// 	$id = $ticket->id;
	// 	if($this->ticket_thread($subject, $body, $id, $user_id)==true)
	// 	{
	// 		return $ticket_number;
	// 	}
	// }
	// //============================================
	// //  Create Ticket 			      | Incomplete
	// //============================================
	// public function ticket_thread($subject, $body, $id, $user_id)
	// {
	// 	$thread = new Ticket_Thread;
	// 	$thread->user_id = $user_id;
	// 	$thread->ticket_id = $id;
	// 	$thread->poster = 'client';
	// 	$thread->title = $subject;
	// 	$thread->body = $body;
	// 	if($thread->save())
	// 	{
	// 		return true;
	// 	}
	// }
	// //============================================
	// //  Generate Random password      | Incomplete
	// //============================================
	// public function generateRandomString($length = 10)
	// {
	//    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	//    	$charactersLength = strlen($characters);
	//     $randomString = '';
	//    	for ($i = 0; $i < $length; $i++)
	//    	{
	//        	$randomString .= $characters[rand(0, $charactersLength - 1)];
	//    	}
	//    	return $randomString;
	// }
	// public function close($id, Tickets $ticket)
	// {
	// 	$ticket_status = $ticket->where('id','=',$id)->first();
	// 	$ticket_status->status = 3;
	// 	$ticket_status->save();
	// 	return "your ticket".$ticket_status->ticket_number." has been closed";
	// }
	// public function resolve($id, Tickets $ticket)
	// {
	// 	$ticket_status = $ticket->where('id','=',$id)->first();
	// 	$ticket_status->status = 2;
	// 	$ticket_status->save();
	// 	return "your ticket".$ticket_status->ticket_number." has been resolved";
	// }
	// public function open($id, Tickets $ticket)
	// {
	// 	$ticket_status = $ticket->where('id','=',$id)->first();
	// 	$ticket_status->status = 1;
	// 	$ticket_status->save();
	// 	return "your ticket".$ticket_status->ticket_number." has been opened";
	// }
	// public function assign($id)
	// {
	// 	return $id;
	// }
}
