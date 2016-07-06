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

class PhpMailController extends Controller {

    public function fetch_smtp_details($id) {
        $emails = Emails::where('id', '=', $id)->first();
        return $emails;
    }

    /**
     * Sending emails from the system.
     *
     * @return Mail
     */
    public function sendmail($from, $to, $message, $template_variables) {
        try {
            // dd($from);
            $from_address = $this->fetch_smtp_details($from);
            if ($from_address == null) {
                return $from_address;
            } else {
                // dd($from_address);
                $username = $from_address->email_address;
                $fromname = $from_address->email_name;
                $password = \Crypt::decrypt($from_address->password);
                $smtpsecure = $from_address->sending_encryption;
                $host = $from_address->sending_host;
                $port = $from_address->sending_port;
                $protocol = $from_address->sending_protocol;

                if (isset($to['email'])) {
                    $recipants = $to['email'];
                } else {
                    $recipants = null;
                }
                if (isset($to['name'])) {
                    $recipantname = $to['name'];
                } else {
                    $recipantname = null;
                }
                if (isset($to['cc'])) {
                    $cc = $to['cc'];
                } else {
                    $cc = null;
                }
                if (isset($to['bc'])) {
                    $bc = $to['bc'];
                } else {
                    $bc = null;
                }
    //            if (isset($message['subject'])) {
    //                $subject = $message['subject'];
    //            } else {
    //                $subject = null;
    //            }
                if (isset($message['body'])) {
                    $content = $message['body'];
                } else {
                    $content = null;
                }
                if (isset($message['scenario'])) {
                    $template = $message['scenario'];
                } else {
                    $template = null;
                }
                if (isset($message['attachments'])) {
                    $attachment = $message['attachments'];
                } else {
                    $attachment = null;
                }

                // template variables
                if (Auth::user()) {
                    $agent = Auth::user()->user_name;
                } else {
                    $agent = null;
                }
                if (isset($template_variables['ticket_agent_name'])) {
                    $ticket_agent_name = $template_variables['ticket_agent_name'];
                } else {
                    $ticket_agent_name = null;
                }
                if (isset($template_variables['ticket_number'])) {
                    $ticket_number = $template_variables['ticket_number'];
                } else {
                    $ticket_number = null;
                }
                if (isset($template_variables['ticket_client_name'])) {
                    $ticket_client_name = $template_variables['ticket_client_name'];
                } else {
                    $ticket_client_name = null;
                }
                if (isset($template_variables['ticket_client_email'])) {
                    $ticket_client_email = $template_variables['ticket_client_email'];
                } else {
                    $ticket_client_email = null;
                }
                if (isset($template_variables['ticket_body'])) {
                    $ticket_body = $template_variables['ticket_body'];
                } else {
                    $ticket_body = null;
                }
                if (isset($template_variables['ticket_assigner'])) {
                    $ticket_assigner = $template_variables['ticket_assigner'];
                } else {
                    $ticket_assigner = null;
                }
                if (isset($template_variables['ticket_link_with_number'])) {
                    $ticket_link_with_number = $template_variables['ticket_link_with_number'];
                } else {
                    $ticket_link_with_number = null;
                }
                // if (isset($template_variables['system_from'])) {
                //     $system_from = $template_variables['system_from'];
                // } else {
                //     $system_from = null;
                // }
                if (isset($template_variables['system_link'])) {
                    $system_link = $template_variables['system_link'];
                } else {
                    $system_link = null;
                }
                if (isset($template_variables['system_error'])) {
                    $system_error = $template_variables['system_error'];
                } else {
                    $system_error = null;
                }
                if (isset($template_variables['agent_sign'])) {
                    $agent_sign = $template_variables['agent_sign'];
                } else {
                    $agent_sign = null;
                }
                if (isset($template_variables['department_sign'])) {
                    $department_sign = $template_variables['department_sign'];
                } else {
                    $department_sign = null;
                }
                if (isset($template_variables['password_reset_link'])) {
                    $password_reset_link = $template_variables['password_reset_link'];
                } else {
                    $password_reset_link = null;
                }
                if (isset($template_variables['user_password'])) {
                    $user_password = $template_variables['user_password'];
                } else {
                    $user_password = null;
                }
                if (isset($template_variables['email_address'])) {
                    $email_address = $template_variables['email_address'];
                } else {
                    $email_address = null;
                }
                if (isset($template_variables['user'])) {
                    $user = $template_variables['user'];
                } else {
                    $user = null;
                }

                $system_link = url('/');

                $system_from = $this->company();

                $mail = new \PHPMailer();

                $status = \DB::table('settings_email')->first();

                $path2 = \Config::get('view.paths');

    //            $directory = $path2[0].DIRECTORY_SEPARATOR.'emails'.DIRECTORY_SEPARATOR.$status->template.DIRECTORY_SEPARATOR;
    //
    //            $handle = fopen($directory.$template.'.blade.php', 'r');
    //            $contents = fread($handle, filesize($directory.$template.'.blade.php'));
    //            fclose($handle);

                $template = TemplateType::where('name', '=', $template)->first();

                $set = \App\Model\Common\TemplateSet::where('name', '=', $status->template)->first();

                if (isset($set['id'])) {
                    $template_data = \App\Model\Common\Template::where('set_id', '=', $set->id)->where('type', '=', $template->id)->first();
                    $contents = $template_data->message;
                    if ($template_data->variable == 1) {
                        if ($template_data->subject) {
                            $subject = $template_data->subject;
                            if ($ticket_number != null) {
                                $subject = $subject . ' [#' . $ticket_number . ']';
                            }
                        } else {
                            $subject = $message['subject'];
                        }
                    } else {
                        $subject = $message['subject'];
                    }
                } else {
                    $contents = null;
                    $subject = null;
                }

                $variables = ['{!!$user!!}', '{!!$agent!!}', '{!!$ticket_number!!}', '{!!$content!!}', '{!!$from!!}', '{!!$ticket_agent_name!!}', '{!!$ticket_client_name!!}', '{!!$ticket_client_email!!}', '{!!$ticket_body!!}', '{!!$ticket_assigner!!}', '{!!$ticket_link_with_number!!}', '{!!$system_error!!}', '{!!$agent_sign!!}', '{!!$department_sign!!}', '{!!$password_reset_link!!}', '{!!$email_address!!}', '{!!$user_password!!}', '{!!$system_from!!}', '{!!$system_link!!}'];

                $data = [$user, $agent, $ticket_number, $content, $from, $ticket_agent_name, $ticket_client_name, $ticket_client_email, $ticket_body, $ticket_assigner, $ticket_link_with_number, $system_error, $agent_sign, $department_sign, $password_reset_link, $email_address, $user_password, $system_from, $system_link];

                // dd($variables,$data,$contents);
                // $messagebody = str_replace($variables, $data, $contents);

                foreach ($variables as $key => $variable) {
                    $messagebody = str_replace($variables[$key], $data[$key], $contents);
                    // dd($messagebody);

                    $contents = $messagebody;
                }

                // dd($messagebody);
                //$mail->SMTPDebug = 3;                // Enable verbose debug output
                if ($protocol == 'smtp') {
                    $mail->isSMTP();                   // Set mailer to use SMTP
                    $mail->Host = $host;               // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;            // Enable SMTP authentication
                    $mail->Username = $username;       // SMTP username
                    $mail->Password = $password;       // SMTP password
                    $mail->SMTPSecure = $smtpsecure;   // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;               // TCP port to connect to
                    $mail->setFrom($username, $fromname);
                } elseif ($protocol == 'mail') {
                    $mail->IsSendmail();               // telling the class to use SendMail transport
                    if ($username == $fromname) {
                        $mail->setFrom($username);
                    } else {
                        $mail->setFrom($username, $fromname);
                    }
                }
                $mail->addAddress($recipants);         // Add a recipient
                // Name is optional
                // $mail->addReplyTo('sada059@gmail.com', 'Information');
                // Optional name
                $mail->isHTML(true);                   // Set email format to HTML
                if ($cc != null) {
                    foreach ($cc as $collaborator) {
                        //mail to collaborators
                        $collab_user_id = $collaborator->user_id;
                        $user_id_collab = User::where('id', '=', $collab_user_id)->first();
                        $collab_email = $user_id_collab->email;
                        $mail->addCC($collab_email);
                    }
                }

    //            $mail->addBCC($bc);

                if ($attachment != null) {
                    $size = count($message['attachments']);
                    $attach = $message['attachments'];
                    for ($i = 0; $i < $size; $i++) {
                        $file_path = $attach[$i]->getRealPath();
                        $file_name = $attach[$i]->getClientOriginalName();
                        $mail->addAttachment($file_path, $file_name);
                    }
                }
                $mail->CharSet = "utf8";
                $mail->Subject = $subject;
                if ($template == 'ticket-reply-agent') {
                    $line = '---Reply above this line--- <br/><br/>';
                    $mail->Body = $line . $messagebody;
                } else {
                    $mail->Body = $messagebody;
                }

                // $mail->AltBody = $altbody;

                if (!$mail->send()) {
                    return;
                    // echo 'Message could not be sent.';
                    // echo 'Mailer Error: '.$mail->ErrorInfo;
                } else {
                    return 1;
                    // echo 'Message has been sent';
                }
            }
        } catch (Exception $e) {
            if($e instanceof ErrorException) {
                return \Lang::get('lang.outgoing_email_failed');
            } 
        }
    }

    /**
     * Sending emails from the system.
     *
     * @return MailNotification
     */
    public function sendEmail($from, $to, $message) {
        try {
            $from_address = $this->fetch_smtp_details($from);
            if ($from_address == null) {
                return $from_address;
            } else {
                $username = $from_address->email_address;
                $fromname = $from_address->email_name;
                $password = \Crypt::decrypt($from_address->password);
                $smtpsecure = $from_address->sending_encryption;
                $host = $from_address->sending_host;
                $port = $from_address->sending_port;
                $protocol = $from_address->sending_protocol;

                if (isset($to['email'])) {
                    $recipants = $to['email'];
                } else {
                    $recipants = null;
                }
                if (isset($to['name'])) {
                    $recipantname = $to['name'];
                } else {
                    $recipantname = null;
                }
                if (isset($to['cc'])) {
                    $cc = $to['cc'];
                } else {
                    $cc = null;
                }
                if (isset($to['bc'])) {
                    $bc = $to['bc'];
                } else {
                    $bc = null;
                }
                if (isset($message['subject'])) {
                    $subject = $message['subject'];
                } else {
                    $subject = null;
                }
                if (isset($message['body'])) {
                    $content = $message['body'];
                } else {
                    $content = null;
                }
                if (isset($message['scenario'])) {
                    $template = $message['scenario'];
                } else {
                    $template = null;
                }
                if (isset($message['attachments'])) {
                    $attachment = $message['attachments'];
                } else {
                    $attachment = null;
                }

                // template variables
                if (Auth::user()) {
                    $agent = Auth::user()->user_name;
                } else {
                    $agent = null;
                }

                $system_link = url('/');

                $system_from = $this->company();

                $mail = new \PHPMailer();

                $status = \DB::table('settings_email')->first();

                // dd($messagebody);
                //$mail->SMTPDebug = 3;                               // Enable verbose debug output
                if ($protocol == 'smtp') {
                    $mail->isSMTP();                   // Set mailer to use SMTP
                    $mail->Host = $host;               // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;            // Enable SMTP authentication
                    $mail->Username = $username;       // SMTP username
                    $mail->Password = $password;       // SMTP password
                    $mail->SMTPSecure = $smtpsecure;   // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;               // TCP port to connect to
                    $mail->setFrom($username, $fromname);
                } elseif ($protocol == 'mail') {
                    $mail->IsSendmail();               // telling the class to use SendMail transport
                    if ($username == $fromname) {
                        $mail->setFrom($username);
                    } else {
                        $mail->setFrom($username, $fromname);
                    }
                }
                $mail->addAddress($recipants);     // Add a recipient
                // Name is optional
                // $mail->addReplyTo('sada059@gmail.com', 'Information');
                // Optional name
                $mail->isHTML(true);                                  // Set email format to HTML
                if ($cc != null) {
                    foreach ($cc as $collaborator) {
                        //mail to collaborators
                        $collab_user_id = $collaborator->user_id;
                        $user_id_collab = User::where('id', '=', $collab_user_id)->first();
                        $collab_email = $user_id_collab->email;
                        $mail->addCC($collab_email);
                    }
                }
                if ($attachment != null) {
                    $size = count($message['attachments']);
                    $attach = $message['attachments'];
                    for ($i = 0; $i < $size; $i++) {
                        $file_path = $attach[$i]->getRealPath();
                        $file_name = $attach[$i]->getClientOriginalName();
                        $mail->addAttachment($file_path, $file_name);
                    }
                }
                $mail->CharSet = "utf8";
                $mail->Subject = $subject;
                $mail->Body = $content;
                if (!$mail->send()) {
                } else {
                }
            }
        } catch (Exception $e) {
            if($e instanceof ErrorException) {
                return \Lang::get('lang.outgoing_email_failed');
            } 
        }
    }

    /**
     * Fetching comapny name to send mail.
     *
     * @return type
     */
    public function company() {
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
    public function mailfrom($reg, $dept_id) {
        $email = Email::where('id', '=', '1')->first();
        if ($reg == 1) {
            return $email->sys_email;
        } elseif ($dept_id > 0) {
            $department = Department::where('id', '=', $dept_id)->first();
            if ($department->outgoing_email) {
                return $department->outgoing_email;
            } else {
                return $email->sys_email;
            }
        }
    }

}
