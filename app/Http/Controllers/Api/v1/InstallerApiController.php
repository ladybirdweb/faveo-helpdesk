<?php

namespace App\Http\Controllers\Api\v1;

// controllers
use App\Http\Controllers\Controller;
// requests
use App\Model\helpdesk\Settings\System;
// models
use App\Model\helpdesk\Utility\Date_time_format;
use App\Model\helpdesk\Utility\Timezones;
use App\User;
use Artisan;
// classes
use Config;
use File;
use Hash;
use Illuminate\Http\Request;

/**
 * |=======================================================================
 * |Class: InstallController
 * |=======================================================================.
 *
 *  Class to perform the first install operation without this the database
 *  settings could not be started
 *
 *  @author     Ladybird <info@ladybirdweb.com>
 */
class InstallerApiController extends Controller
{
    /**
     * config_database
     * This function is to configure the database and install the application via API call.
     *
     * @return type Json
     */
    public function config_database(Request $request)
    {
        error_reporting(E_ALL & ~E_NOTICE);

        // Check for pre install
        if (\Config::get('database.install') == '%0%') {
            $default = $request->database;
            $host = $request->host;
            $database = $request->databasename;
            $dbusername = $request->dbusername;
            $dbpassword = $request->dbpassword;
            $port = $request->port;

            if (isset($default) && isset($host) && isset($database) && isset($dbusername)) {

                // Setting environment values
                $_ENV['DB_TYPE'] = $default;
                $_ENV['DB_HOST'] = $host;
                $_ENV['DB_PORT'] = $port;
                $_ENV['DB_DATABASE'] = $database;
                $_ENV['DB_USERNAME'] = $dbusername;
                $_ENV['DB_PASSWORD'] = $dbpassword;

                $config = '';
                foreach ($_ENV as $key => $val) {
                    $config .= "{$key}={$val}\n";
                }

                // Write environment file
                $fp = fopen(base_path().'/.env', 'w');
                fwrite($fp, $config);
                fclose($fp);

                return ['response' => 'success', 'status' => '1'];
            } else {
                return ['response' => 'fail', 'reason' => 'insufficient parameters', 'status' => '0'];
            }
        } else {
            return ['response' => 'fail', 'reason' => 'this system is already installed', 'status' => '0'];
        }
    }

    /**
     * config_database
     * This function is to configure the database and install the application via API call.
     *
     * @return type Json
     */
    public function config_system(Request $request)
    {
        // Check for pre install
        if (\Config::get('database.install') == '%0%') {
            $firstname = $request->firstname;
            $lastname = $request->lastname;
            $email = $request->email;
            $username = $request->username;
            $password = $request->password;
            $timezone = $request->timezone;
            $datetime = $request->datetime;

            // Migrate database
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);

            // checking requested timezone for the admin and system
            $timezones = Timezones::where('name', '=', $timezone)->first();
            if ($timezones->id == null) {
                return ['response' => 'fail', 'reason' => 'Invalid time-zone', 'status' => '0'];
            }
            // checking requested date time format for the admin and system
            $date_time_format = Date_time_format::where('format', '=', $datetime)->first();
            if ($date_time_format->id == null) {
                return ['response' => 'fail', 'reason' => 'invalid date-time format', 'status' => '0'];
            }
            // Creating minum settings for system
            $system = new System();
            $system->status = 1;
            $system->department = 1;
            $system->date_time_format = $date_time_format->id;
            $system->time_zone = $timezones->id;
            $system->save();

            // Creating user
            $user = User::create([
                        'first_name'   => $firstname,
                        'last_name'    => $lastname,
                        'email'        => $email,
                        'user_name'    => $username,
                        'password'     => Hash::make($password),
                        'active'       => 1,
                        'role'         => 'admin',
                        'assign_group' => 1,
                        'primary_dpt'  => 1,
            ]);

            // Setting database installed status
            $value = '1';
            $install = app_path('../config/database.php');
            $datacontent = File::get($install);
            $datacontent = str_replace('%0%', $value, $datacontent);
            File::put($install, $datacontent);

            // Applying email configuration on route
            $smtpfilepath = "\App\Http\Controllers\Common\SettingsController::smtp()";
            $lfmpath = "url('photos').'/'";
            $path22 = app_path('Http/routes.php');
            $path23 = base_path('config/lfm.php');
            $content23 = File::get($path22);
            $content24 = File::get($path23);
            $content23 = str_replace('"%smtplink%"', $smtpfilepath, $content23);
            $content24 = str_replace("'%url%'", $lfmpath, $content24);
            File::put($path22, $content23);
            File::put($path23, $content24);

            // If user created return success
            if ($user) {
                return ['response' => 'success', 'status' => '1'];
            }
        } else {
            return ['response' => 'fail', 'reason' => 'this system is already installed', 'status' => '0'];
        }
    }
}
