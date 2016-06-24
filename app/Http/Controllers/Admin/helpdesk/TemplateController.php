<?php

namespace App\Http\Controllers\Admin\helpdesk;

// controllers
use App\Http\Controllers\Common\PhpMailController;
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\DiagnosRequest;
use App\Http\Requests\helpdesk\TemplateRequest;
use App\Http\Requests\helpdesk\TemplateUdate;
// models
use App\Model\helpdesk\Email\Emails;
use App\Model\helpdesk\Email\Template;
use App\Model\helpdesk\Utility\Languages;
// classes
use Exception;
use Illuminate\Http\Request;
use Input;
use Lang;

/**
 * TemplateController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class TemplateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type void
     */
    public function __construct(PhpMailController $PhpMailController)
    {
        $this->PhpMailController = $PhpMailController;
        $this->middleware('auth');
        $this->middleware('roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @param type Template $template
     *
     * @return type Response
     */
    public function index(Template $template)
    {
        try {
            $templates = $template->get();

            return view('themes.default1.admin.helpdesk.emails.template.index', compact('templates'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param type Languages $language
     * @param type Template  $template
     *
     * @return type Response
     */
    public function create(Languages $language, Template $template)
    {
        try {
            $templates = $template->get();
            $languages = $language->get();

            return view('themes.default1.admin.helpdesk.emails.template.create', compact('languages', 'templates'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type Template        $template
     * @param type TemplateRequest $request
     *
     * @return type Response
     */
    public function store(Template $template, TemplateRequest $request)
    {
        try {
            /* Check whether function success or not */
            if ($template->fill($request->input())->save() == true) {
                /* redirect to Index page with Success Message */
                return redirect('template')->with('success', 'Teams  Created Successfully');
            } else {
                /* redirect to Index page with Fails Message */
                return redirect('template')->with('fails', 'Teams  can not Create');
            }
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('template')->with('fails', 'Teams  can not Create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type           $id
     * @param type Template  $template
     * @param type Languages $language
     *
     * @return type Response
     */
    public function listdirectories()
    {
        $path = \Config::get('view.paths')[0].'/emails/';
        $directories = scandir($path);
        $directory = str_replace('/', '-', $path);

        return view('themes.default1.admin.helpdesk.emails.template.listdirectories', compact('directories', 'directory'));
    }

    public function listtemplates($template, $path)
    {
        $paths = str_replace('-', '/', $path);
        $directory2 = $paths.$template;

        $templates = scandir($directory2);
        $directory = str_replace('/', '-', $directory2.'/');

        return view('themes.default1.admin.helpdesk.emails.template.listtemplates', compact('templates', 'directory'));
    }

    public function readtemplate($template, $path)
    {
        $directory = str_replace('-', '/', $path);
        $handle = fopen($directory.$template, 'r');
        $contents = fread($handle, filesize($directory.$template));
        fclose($handle);

        return view('themes.default1.admin.helpdesk.emails.template.readtemplates', compact('contents', 'template', 'path'));
    }

    public function createtemplate()
    {
        $directory = '../resources/views/emails/';
        $fname = Input::get('folder_name');
        $filename = $directory.$fname;

// images folder creation using php
//   $mydir = dirname( __FILE__ )."/html/images";
//   if(!is_dir($mydir)){
//   mkdir("html/images");
//   }
        // Move all images files

        if (!file_exists($filename)) {
            mkdir($filename, 0777);
        }
        $files = array_filter(scandir($directory.'default'));

        foreach ($files as $file) {
            if ($file === '.' or $file === '..') {
                continue;
            }
            if (!is_dir($file)) {
                //   $file_to_go = str_replace("code/resources/views/emails/",'code/resources/views/emails/'.$fname,$file);
                $destination = $directory.$fname.'/';

                copy($directory.'default/'.$file, $destination.$file);
            }
        }

        return \Redirect::back()->with('success', 'Successfully copied');
    }

    public function writetemplate($template, $path)
    {
        $directory = str_replace('-', '/', $path);
        $b = Input::get('templatedata');

        file_put_contents($directory.$template, print_r($b, true));

        return \Redirect::back()->with('success', 'Successfully updated');
    }

    public function deletetemplate($template, $path)
    {
        $directory = str_replace('-', '/', $path);
        $dir = $directory.$template;
        $status = \DB::table('settings_email')->first();
        if ($template == 'default' or $template == $status->template) {
            return \Redirect::back()->with('fails', 'You cannot delete a default or active directory!');
        }
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    unlink($dir.'/'.$object);
                }
            }
            rmdir($dir);
        } else {
            rmdir($dir);
        }

        return \Redirect::back()->with('success', 'Successfully Deleted');
    }

    public function activateset($setname)
    {
        \DB::table('settings_email')->update(['template' => $setname]);

        return \Redirect::back()->with('success', 'You have Successfully Activated this Set');
    }

    public function edit($id, Template $template, Languages $language)
    {
        try {
            $templates = $template->whereId($id)->first();
            $languages = $language->get();

            return view('themes.default1.admin.helpdesk.emails.template.edit', compact('templates', 'languages'));
        } catch (Exception $e) {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int           $id
     * @param type Template      $template
     * @param type TemplateUdate $request
     *
     * @return type Response
     */
    public function update($id, Template $template, TemplateUdate $request)
    {
        try {
            //TODO validation
            $templates = $template->whereId($id)->first();
            /* Check whether function success or not */
            if ($templates->fill($request->input())->save() == true) {
                /* redirect to Index page with Success Message */
                return redirect('template')->with('success', 'Teams  Updated Successfully');
            } else {
                /* redirect to Index page with Fails Message */
                return redirect('template')->with('fails', 'Teams can not Update');
            }
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('template')->with('fails', 'Teams can not Update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param type int      $id
     * @param type Template $template
     *
     * @return type Response
     */
    public function destroy($id, Template $template)
    {
        try {
            $templates = $template->whereId($id)->first();
            /* Check whether function success or not */
            if ($templates->delete() == true) {
                /* redirect to Index page with Success Message */
                return redirect('template')->with('success', 'Teams  Deleted Successfully');
            } else {
                /* redirect to Index page with Fails Message */
                return redirect('template')->with('fails', 'Teams  can not Delete');
            }
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('template')->with('fails', 'Teams  can not Delete');
        }
    }

    /**
     * Form for Email connection checking.
     *
     * @param type Emails $email
     *
     * @return type Response
     */
    public function formDiagno(Emails $email)
    {
        try {
            $emails = $email->get();

            return view('themes.default1.admin.helpdesk.emails.template.formDiagno', compact('emails'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * function to send  emails.
     *
     * @param type Request $request
     *
     * @return type
     */
    public function postDiagno(DiagnosRequest $request)
    {
        try {
            $email_details = Emails::where('id', '=', $request->from)->first();
            if ($email_details->sending_protocol == 'mail') {
                $mail = new \PHPMailer(); // defaults to using php "mail()"
                $mail->IsSendmail(); // telling the class to use SendMail transport
                $mail->SetFrom($email_details->email_address, $email_details->email_name); // sender details
                $address = $request->to; // receiver email
                $mail->AddAddress($address);
                $mail->Subject = utf8_decode($request->subject); // subject of the email
                $body = utf8_decode($request->message); // body of the email
                $mail->MsgHTML($body);
                if (!$mail->Send()) {
                    $return = Lang::get('lang.mailer_error').': '.$mail->ErrorInfo;
                } else {
                    $return = Lang::get('lang.message_has_been_sent');
                }
            } elseif ($email_details->sending_protocol == 'smtp') {
                $mail = new \PHPMailer();
                $mail->isSMTP();                                            // Set mailer to use SMTP
                if ($email_details->smtp_validate == '1') {
                    $mail->SMTPOptions = [
                        'ssl' => [
                            'verify_peer'       => false,
                            'verify_peer_name'  => false,
                            'allow_self_signed' => true,
                        ],
                    ];
                }
                $mail->Host = $email_details->sending_host;                 // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                $mail->Username = $email_details->email_address;                 // SMTP username
                $mail->Password = \Crypt::decrypt($email_details->password);                           // SMTP password
                $mail->SMTPSecure = $email_details->sending_encryption;                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = $email_details->sending_port;                                    // TCP port to connect to
                $mail->setFrom($email_details->email_address, $email_details->email_name);
                $mail->addAddress($request->to, '');     // Add a recipient
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = utf8_decode($request->subject);
                $mail->Body = utf8_decode($request->message);
                if (!$mail->send()) {
                    $return = Lang::get('lang.mailer_error').': '.$mail->ErrorInfo;
                } else {
                    $return = Lang::get('lang.message_has_been_sent');
                }
            }

            return redirect()->back()->with('success', $return);
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }
}
