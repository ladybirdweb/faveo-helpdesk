<?php

function loging($context, $message, $level = 'error', $array = [])
{
    \Log::$level($message.':-:-:-'.$context, $array);
}
function checkArray($key, $array)
{
    $value = '';
    if (is_array($array) && array_key_exists($key, $array)) {
        $value = $array[$key];
    }

    return $value;
}
function mime($type)
{
    if ($type == 'jpg' ||
            $type == 'png' ||
            $type == 'PNG' ||
            $type == 'JPG' ||
            $type == 'jpeg' ||
            $type == 'JPEG' ||
            $type == 'gif' ||
            $type == 'GIF' ||
            $type == 'image/jpeg' ||
            $type == 'image/jpg' ||
            $type == 'image/gif' ||
            // $type == "application/octet-stream" ||
            $type == 'image/png' ||
            starts_with($type, 'image')) {
        return 'image';
    }
}
function removeUnderscore($string)
{
    if (str_contains($string, '_') === true) {
        $string = str_replace('_', ' ', $string);
    }

    return ucfirst($string);
}
function isItil()
{
    $check = false;
    if (\Schema::hasTable('sd_releases') && \Schema::hasTable('sd_changes') && \Schema::hasTable('sd_problem')) {
        $check = true;
    }

    return $check;
}
function isAsset()
{
    $check = false;
    if (\Schema::hasTable('sd_assets')) {
        $check = true;
    }

    return $check;
}
function itilEnabled()
{
    $check = false;
    if (\Schema::hasTable('common_settings')) {
        $settings = \DB::table('common_settings')->where('option_name', 'itil')->first();
        if ($settings && $settings->status == 1) {
            $check = true;
        }
    }

    return $check;
}
function isBill()
{
    $check = false;
    if (\Schema::hasTable('common_settings')) {
        $settings = \DB::table('common_settings')->where('option_name', 'bill')->first();
        if ($settings && $settings->status == 1) {
            $check = true;
        }
    }

    return $check;
}
function deletePopUp($id, $url, $title = 'Delete', $class = 'btn btn-sm btn-danger', $btn_name
= 'Delete', $button_check = true)
{
    $button = '';
    if ($button_check == true) {
        $button = '<a href="#delete" class="'.$class.'" data-toggle="modal" data-target="#delete'.$id.'">'.$btn_name.'</a>';
    }

    return $button.'<div class="modal fade" id="delete'.$id.'">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">'.$title.'</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <div class="col-md-12">
                                <p>Are you sure ?</p>
                                </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <a href="'.$url.'" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>';
}
function isInstall()
{
    $check = false;
    $env = base_path('.env');
    if (\File::exists($env) && env('DB_INSTALL') == 1) {
        $check = true;
    }

    return $check;
}
function faveotime($date, $hour = 0, $min = 0, $sec = 0)
{
    if (is_bool($hour) && $hour == true) {
        $hour = $date->hour;
    }
    if (is_bool($min) && $min == true) {
        $min = $date->minute;
    }
    if (is_bool($sec) && $sec == true) {
        $sec = $date->second;
    }
    $date1 = \Carbon\Carbon::create($date->year, $date->month, $date->day, $hour, $min, $sec);

    return $date1->hour($hour)->minute($min)->second($sec);
}
function getCarbon($date, $glue = '-', $format = 'Y-m-d', $flag = true)
{
    //dd($date,$glue);
    $parse = explode($glue, $date);
    if ($format == 'Y-m-d') {
        $day = $parse[2];
        $month = $parse[1];
        $year = $parse[0];
    }

    if ($format == 'm-d-Y') {
        $month = $parse[0];
        $day = $parse[1];
        $year = $parse[2];
    }

    $hour = 0;
    $minute = 0;
    $second = 0;
    if ($format == 'Y-m-d H:m:i') {
        $day = $parse[2];
        $month = $parse[1];
        $year = $parse[0];
    }
    if (!$flag) {
        $hour = 23;
        $minute = 59;
        $second = 59;
    }
    $carbon = \Carbon\Carbon::create($year, $month, $day, $hour, $minute, $second);

    return $carbon;
}
function createCarbon($date, $tz = '', $format = '')
{
    if (!$tz) {
        $tz = timezone();
    }
    if (!$format) {
        $format = dateformat();
    }

    return \Carbon\Carbon::parse($date)->tz($tz)->format($format);
}
function carbon($date)
{
    return \Carbon\Carbon::parse($date);
}
function timezone()
{
    $system = App\Model\helpdesk\Settings\System::select('time_zone')->first();
    $tz = 'UTC';
    if ($system) {
        $tz = $system->time_zone;
    }

    return $tz;
}
function dateformat()
{
    $system = App\Model\helpdesk\Settings\System::select('date_time_format')->first();
    $format = 'Y-m-d H:m:i';
    if ($system) {
        $format = $system->date_time_format;
    }

    return $format;
}
function faveoUrl($route)
{
    $url = \Config::get('app.url');
    //dd($url."/".$route);
    return $url.$route;
}
/**
 * @category function to UTF encoding
 *
 * @param string name
 *
 * @return string name
 */
function utfEncoding($name)
{
    $title = '';
    $array = imap_mime_header_decode($name);
    if (is_array($array) && count($array) > 0) {
        foreach ($array as $text) {
            $title .= $text->text;
        }
        $name = $title;
    }

    return $name;
}
function role($id)
{
    $user = \App\User::where('id', $id)->select('role')->first();
    if ($user) {
        return $user->role;
    }
}
function title($ticketid)
{
    $thread = firstThread($ticketid);
    if ($thread) {
        return $thread->title;
    }
}
function requester($ticketid)
{
    $ticket = ticket($ticketid);
    if ($ticket) {
        return $ticket->user_id;
    }
}
function thread($threadid)
{
    return App\Model\helpdesk\Utility\Ticket_thread::where('id', $threadid)
                    ->select('title', 'user_id', 'id', 'poster', 'is_internal')
                    ->first();
}
function poster($threadid)
{
    $thread = thread($threadid);
    if ($thread) {
        return $thread->poster;
    }
}
function threadType($threadid)
{
    $thread = thread($threadid);
    if ($thread) {
        return $thread->thread_type;
    }
}
function lastResponder($ticketid)
{
    $thread = App\Model\helpdesk\Utility\Ticket_thread::where('ticket_id', $ticketid)
            ->whereNotNull('user_id')
            ->where('user_id', '')
            ->orderBy('id', 'desc')
            ->first();
    if ($thread) {
        return $thread->user_id;
    }
}
function ticket($ticketid)
{
    return App\Model\helpdesk\Ticket\Tickets::where('id', $ticketid)
                    ->select('user_id', 'assigned_to', 'sla', 'priority_id', 'dept_id', 'source', 'duedate')
                    ->first();
}
function firstThread($ticketid)
{
    return App\Model\helpdesk\Utility\Ticket_thread::where('ticket_id', $ticketid)
                    ->whereNotNull('title')
                    ->where('title', '!=', '')
                    ->select('title', 'user_id', 'id', 'poster', 'is_internal')
                    ->first();
}
function lastThread($ticketid)
{
    return App\Model\helpdesk\Utility\Ticket_thread::where('ticket_id', $ticketid)
                    ->orderBy('id', 'desc')
                    ->first();
}
function source($ticketid)
{
    $ticket = ticket($ticketid);
    if ($ticket) {
        return $ticket->source;
    }
}
function dueDateUTC($ticketid)
{
    $ticket = ticket($ticketid);
    if ($ticket) {
        return $ticket->duedate;
    }
}
function dueDate($ticketid)
{
    $ticket = ticket($ticketid);
    if ($ticket) {
        return $ticket->duedate->tz(timezone());
    }
}
function getDateFromString($str)
{
    $reg = '/\d{2}\/\d{2}\/\d{4}.\d{2}:\d{2}:\d{2}/';
    $match = preg_match($reg, $str, $matches);
    if (!$matches) {
        $reg = '/\d{2}\-\d{2}\-\d{4}.\d{2}:\d{2}:\d{2}/';
        $match = preg_match($reg, $str, $matches);
    }
    if (!$matches) {
        $reg = '/\d{2}\.\d{2}\.\d{4}.\d{2}:\d{2}:\d{2}/';
        $match = preg_match($reg, $str, $matches);
    }
    if (!$matches) {
        $reg = '/\d{4}\.\d{2}\.\d{2}.\d{2}:\d{2}:\d{2}/';
        $match = preg_match($reg, $str, $matches);
    }
    if (!$matches) {
        $reg = '/\d{4}\/\d{2}\/\d{2}.\d{2}:\d{2}:\d{2}/';
        $match = preg_match($reg, $str, $matches);
    }
    if (!$matches) {
        $reg = '/\d{4}\-\d{2}\-\d{2}.\d{2}:\d{2}:\d{2}/';
        $match = preg_match($reg, $str, $matches);
    }
    if ($match) {
        $date = checkArray(0, $matches);
        $carbon = carbon($date);

        return $carbon;
    }
}
function convertToHours($time, $format = '%02d:%02d')
{
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);

    return sprintf($format, $hours, $minutes);
}
function collapse($array)
{
    $arrays = [];
    if (count($array) > 0) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    if (!is_array($v)) {
                        $arrays[$k] = $v;
                    }
                }
            }
        }
    }

    return $arrays;
}
function delTree($dir)
{
    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }

    return rmdir($dir);
}
function humanReadingDate($carbon)
{
    //$now = \Carbon\Carbon::now()->tz(timezone());
    return $carbon->diffForHumans();
}
function faveoDate($date = '', $format = '', $tz = '')
{
    if (!$date) {
        $date = \Carbon\Carbon::now();
    }
    if (!is_object($date)) {
        $date = carbon($date);
    }
    if (!$format || !$tz) {
        $system = App\Model\helpdesk\Settings\System::select('time_zone', 'date_time_format')->first();
    }
    if (!$format) {
        $format = $system->date_time_format;
    }
    if (!$tz) {
        $tz = $system->time_zone;
    }

    try {
        if ($format == 'human-read') {
            return $date->tz($tz)->diffForHumans();
        }

        return $date->tz($tz)->format($format);
    } catch (\Exception $ex) {
        dd($ex);

        return 'invalid';
    }
}
function domainUrl()
{
    return sprintf(
            '%s://%s', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https'
                        : 'http', $_SERVER['SERVER_NAME']
    );
}
function ticketNumber($ticketid)
{
    return App\Model\helpdesk\Ticket\Tickets::where('id', $ticketid)
                    ->select('ticket_number')
                    ->value('ticket_number');
}
function isPlugin($plugin = 'ServiceDesk')
{
    $plugin = \DB::table('plugins')->where('name', $plugin)->where('status', 1)->count();
    $check = false;
    if ($plugin > 0) {
        $check = true;
    }

    return $check;
}
function file_upload_max_size()
{
    static $max_size = -1;

    if ($max_size < 0) {
        // Start with post_max_size.
        $max_size = parse_size(ini_get('post_max_size'));

        // If upload_max_size is less, then reduce. Except if upload_max_size is
        // zero, which indicates no limit.
        $upload_max = parse_size(ini_get('upload_max_filesize'));
        if ($upload_max > 0 && $upload_max < $max_size) {
            $max_size = $upload_max;
        }
    }

    return ($max_size / 1024) / 1024;
}
function parse_size($size)
{
    $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
    $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
    if ($unit) {
        // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
        return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
    } else {
        return round($size);
    }
}
function storageDrive()
{
    $drive = 'local';
    $settings = \DB::table('common_settings')->where('option_name', 'storage')
                    ->where('optional_field', 'default')->first();
    if ($settings && $settings->option_value) {
        $drive = $settings->option_value;
    }

    return $drive;
}
/**
 * @category funcion to get the value of account activation method
 *
 * @param object of model CommonSettings : $settings
 *
 * @var string $value
 *
 * @return string $value: value of activation option fetched from DB
 */
function getAccountActivationOptionValue()
{
    $value = App\Model\helpdesk\Settings\CommonSettings::select('option_value')->where('option_name', '=', 'account_actvation_option')->first();

    return $value->option_value;
}
/**
 * @category Funcion to set validation rule for email
 *
 * @param null
 *
 * @return string : validation rule
 */
function getEmailValidation()
{
    $value = getAccountActivationOptionValue();
    $email_mandatory = App\Model\helpdesk\Settings\CommonSettings::select('status')->where('option_name', '=', 'email_mandatory')->first();
    if ($value == 'email' || $value == 'email,mobile' || $email_mandatory->status
            == 1) {
        return 'required|max:50|email|unique:users,email';
    } else {
        return 'max:50|email|unique:users,email';
    }
}
/**
 * @category Funcion to set validation rule for mobile and code
 *
 * @param string $field : name of field
 *
 * @return string : validation rule
 */
function getMobileValidation($field)
{
    $value = getAccountActivationOptionValue();
    if (strpos($value, 'mobile') !== false) {
        return 'required|numeric|max:999999999999999|unique:users,mobile';
    } else {
        return 'numeric|max:999999999999999|unique:users,mobile';
    }
}
/**
 * get default department id.
 *
 * @return int
 */
function defaultDepartmentId()
{
    $id = '';
    $system = \App\Model\helpdesk\Settings\System::select('department')->first();
    if ($system) {
        $id = $system->department;
    } else {
        $department = App\Model\helpdesk\Agent\Department::select('id')->first();
        $id = $department->id;
    }

    return $id;
}
function isMicroOrg()
{
    $check = false;
    if (\Schema::hasTable('common_settings')) {
        $settings = \DB::table('common_settings')->where('option_name', 'micro_organization_status')->first();
        if ($settings && $settings->status == 1) {
            $check = true;
        }
    }

    return $check;
}
/**
 * @category function to return array values if status id
 *
 * @param string purpose of status
 *
 * @return array ids of status with purpose passed as string
 */
function getStatusArray($status)
{
    $type = new App\Model\helpdesk\Ticket\Ticket_Status();
    $values = $type->where('state', '=', $status)->pluck('id')->toArray();
    return $values;
}
function isCustomMail()
{
    $check = false;
    $drive = config('mail.driver');
    $default = [
        'smtp'     => true,
        'mail'     => true,
        'sendmail' => true,
        'mailgun'  => true,
        'mandrill' => true,
        'log'      => true,
    ];
    // dd($drive, $default);
    if (!checkArray($drive, $default)) {
        $check = true;
    }

    return $check;
}
function departmentByHelptopic($helptopic_id)
{
    $help_topic = \App\Model\helpdesk\Manage\Help_topic::where('id', '=', $helptopic_id)->select('department')->first();
    if ($help_topic) {
        $department_id = $help_topic->department;
    } else {
        $department_id = defaultDepartmentId();
    }

    return $department_id;
}
function commonSettings($option, $option_field)
{
    return \App\Model\helpdesk\Settings\CommonSettings::where('option_name', $option)
                    ->where('optional_field', $option_field)
                    ->value('option_value');
}
function defaultSla()
{
    $id = '';
    $sla = App\Model\helpdesk\Manage\Sla_plan::where('status', 1)->first();
    if ($sla) {
        $id = $sla->id;
    }

    return $id;
}
