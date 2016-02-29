<?php

namespace App\Http\Controllers\Installer\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\InstallerRequest;
// models
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Utility\Date_time_format;
use App\Model\helpdesk\Utility\Timezones;
use App\User;
// classes
use Artisan;
use Config;
use Exception;
use File;
use Hash;
use Input;
use Redirect;
use Session;
use View;

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
class InstallController extends Controller
{
    /**
     * Get Licence (step 1).
     *
     * @return type view
     */
    public function licence()
    {
        // checking if the installation is running for the first time or not
        if (Config::get('database.install') == '%0%') {
            return view('themes/default1/installer/helpdesk/view1');
        } else {
            // return 1;
            return redirect('/auth/login');
        }
    }

    /**
     * Post Licencecheck.
     *
     * @return type view
     */
    public function licencecheck()
    {
        // checking if the user have accepted the licence agreement
        $accept = (Input::has('accept1')) ? true : false;
        if ($accept == 'accept') {
            Session::put('step1', 'step1');

            return Redirect::route('prerequisites');
        } else {
            return Redirect::route('licence')->with('fails', 'Failed! first accept the licence agreeement');
        }
        // return 1;
    }

    /**
     * Get prerequisites (step 2).
     *
     * Checking the extensions enabled required for installing the faveo
     * without which the project cannot be executed properly
     *
     * @return type view
     */
    public function prerequisites()
    {
        // checking if the installation is running for the first time or not
        if (Config::get('database.install') == '%0%') {
            if (Session::get('step1') == 'step1') {
                return View::make('themes/default1/installer/helpdesk/view2');
            } else {
                return Redirect::route('licence');
            }
        } else {
            return redirect('/auth/login');
        }
    }

    /**
     * Post Prerequisitescheck
     * checking prerequisites.
     *
     * @return type view
     */
    public function prerequisitescheck()
    {
        Session::put('step2', 'step2');

        return Redirect::route('configuration');
    }

    /**
     * Get Localization (step 3)
     * Requesting user recomended settings for installation.
     *
     * @return type view
     */
    public function localization()
    {
        // checking if the installation is running for the first time or not
        if (Config::get('database.install') == '%0%') {
            if (Session::get('step2') == 'step2') {
                return View::make('themes/default1/installer/helpdesk/view3');
            } else {
                return Redirect::route('prerequisites');
            }
        } else {
            return redirect('/auth/login');
        }
    }

    /**
     * Post localizationcheck
     * checking prerequisites.
     *
     * @return type view
     */
    public function localizationcheck()
    {
        Session::put('step3', 'step3');

        Session::put('language', Input::get('language'));
        Session::put('timezone', Input::get('timezone'));
        Session::put('date', Input::get('date'));
        Session::put('datetime', Input::get('datetime'));

        return Redirect::route('configuration');
    }

    /**
     * Get Configuration (step 4)
     * checking prerequisites.
     *
     * @return type view
     */
    public function configuration()
    {
        // checking if the installation is running for the first time or not
        if (Config::get('database.install') == '%0%') {
            if (Session::get('step2') == 'step2') {
                return View::make('themes/default1/installer/helpdesk/view3');
            } else {
                return Redirect::route('prerequisites');
            }
        } else {
            return redirect('/auth/login');
        }
    }

    /**
     * Post configurationcheck
     * checking prerequisites.
     *
     * @return type view
     */
    public function configurationcheck()
    {
        Session::put('step4', 'step4');
        // dd(Input::get('default'));
        // dd(Input::get('host'));
        // dd(Input::get('databasename'));
        // dd(Input::get('username'));
        // dd(Input::get('password'));
        // dd(Input::get('port'));

        Session::put('default', Input::get('default'));
        Session::put('host', Input::get('host'));
        Session::put('databasename', Input::get('databasename'));
        Session::put('username', Input::get('username'));
        Session::put('password', Input::get('password'));
        Session::put('port', Input::get('port'));

        return Redirect::route('database');
    }

    /**
     * postconnection.
     *
     * @return type view
     */
    public function postconnection()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        $default = Input::get('default');
        $host = Input::get('host');
        $database = Input::get('databasename');
        $dbusername = Input::get('username');
        $dbpassword = Input::get('password');
        $port = Input::get('port');

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

        return 1;
    }

    /**
     * Get database
     * checking prerequisites.
     *
     * @return type view
     */
    public function database()
    {
        // checking if the installation is running for the first time or not
        if (Config::get('database.install') == '%0%') {
            if (Session::get('step4') == 'step4') {
                return View::make('themes/default1/installer/helpdesk/view4');
            } else {
                return Redirect::route('configuration');
            }
        } else {
            return redirect('/auth/login');
        }
    }

    /**
     * Get account
     * checking prerequisites.
     *
     * @return type view
     */
    public function account()
    {
        // checking if the installation is running for the first time or not
        if (Config::get('database.install') == '%0%') {
            if (Session::get('step4') == 'step4') {
                Session::put('step5', 'step5');
                Session::forget('step1');
                Session::forget('step2');
                Session::forget('step3');

                return View::make('themes/default1/installer/helpdesk/view5');
            } else {
                return Redirect::route('configuration');
            }
        } else {
            return redirect('/auth/login');
        }
    }

    /**
     * Post accountcheck
     * checking prerequisites.
     *
     * @param type InstallerRequest $request
     *
     * @return type view
     */
    public function accountcheck(InstallerRequest $request)
    {
        // checking is the installation was done previously
        try {
            $check_for_pre_installation = System::all();
            if ($check_for_pre_installation) {
                return redirect()->back()->with('fails', 'The data in database already exist. Please provide fresh database');
            }
        } catch (Exception $e) {
        }

        // migrate database
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);
        // create user
        $firstname = $request->input('firstname');
        $lastname = $request->input('Lastname');
        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');

        $language = $request->input('language');
        $timezone = $request->input('timezone');
        $date = $request->input('date');
        $datetime = $request->input('datetime');

        //\Cache::forever('language', $language);

        //\App::setLocale($language);
        // $system = System::where('id','=','1')->first();
        // $system->time_zone = $timezone;
        // $system->date_time_format = $datetime;
        // $system->save();
        // checking requested timezone for the admin and system
        $timezones = Timezones::where('name', '=', $timezone)->first();
        if ($timezones->id == null) {
            return ['response' => 'fail', 'reason' => 'Invalid time-zone', 'status' => '0'];
        }
        // var_dump($datetime);
        // checking requested date time format for the admin and system
        $date_time_format = Date_time_format::where('format', '=', $datetime)->first();
        // dd($date_time_format);
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

        // creating an user
        $user = User::create([
                    'first_name'   => $firstname,
                    'last_name'    => $lastname,
                    'email'        => $email,
                    'user_name'    => $username,
                    'password'     => Hash::make($password),
                    'assign_group' => 1,
                    'primary_dpt'  => 1,
                    'active'       => 1,
                    'role'         => 'admin',
        ]);
        // checking if the user have been created
        if ($user) {
            Session::put('step6', 'step6');

            return Redirect::route('final');
        }
    }

    /**
     * Get finalize
     * checking prerequisites.
     *
     * @return type view
     */
    public function finalize()
    {
        // checking if the installation have been completed or not
        if (Session::get('step6') == 'step6') {
            $value = '1';
            $install = app_path('../config/database.php');
            $datacontent = File::get($install);
            $datacontent = str_replace('%0%', $value, $datacontent);
            File::put($install, $datacontent);
            // setting email settings in route
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
            try {
                Session::forget('step1');
                Session::forget('step2');
                Session::forget('step3');
                Session::forget('step4');
                Session::forget('step5');
                Session::forget('step6');

                return View::make('themes/default1/installer/helpdesk/view6');
            } catch (Exception $e) {
                return Redirect::route('npl');
            }
        } else {
            return redirect('/auth/login');
        }
    }

    /**
     * Post finalcheck
     * checking prerequisites.
     *
     * @return type view
     */
    public function finalcheck()
    {
        try {
            return redirect('/auth/login');
        } catch (Exception $e) {
            return redirect('/auth/login');
        }
    }
}
