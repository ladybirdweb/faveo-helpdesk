<?php

namespace App\Http\Controllers\Installer\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\DatabaseRequest;
use App\Http\Requests\helpdesk\InstallerRequest;
use Illuminate\Http\Request;
// models
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Utility\Date_time_format;
use App\Model\helpdesk\Utility\Timezones;
use App\User;
// classes
use Artisan;
use Config;
use DB;
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
class InstallController extends Controller {

    /**
     * Get Licence (step 1).
     *
     * @return type view
     */
    public function licence() {
        Session::flush();
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
    public function licencecheck(Request $request) {
        // checking if the user have accepted the licence agreement
        $accept = (Input::has('accept1')) ? true : false;
        if ($accept == 'accept') {
//            Session::set('step1', 'step1');
            $request->session()->put('step1', 'step1');

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
    public function prerequisites(Request $request) {
//        dd($request->session()->get('step1'));
        // checking if the installation is running for the first time or not
        if (Config::get('database.install') == '%0%') {
//            if (Session::get('step1') == 'step1') {
            if ($request->session()->get('step1') == 'step1') {
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
    public function prerequisitescheck(Request $request) {
//        Session::set('step2', 'step2');
        $request->session()->put('step2', 'step2');
        return Redirect::route('configuration');
    }

    /**
     * Get Localization (step 3)
     * Requesting user recomended settings for installation.
     *
     * @return type view
     */
    public function localization(Request $request) {
//        dd($request->session()->get('step1'));
        // checking if the installation is running for the first time or not
        if (Config::get('database.install') == '%0%') {
//            if (Session::get('step2') == 'step2') {
            if ($request->session()->get('step2') == 'step2') {
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
    public function localizationcheck(Request $request) {
//        dd($request->session()->get('step1'));
//        Session::set('step3', 'step3');
//        Session::set('language', Input::get('language'));
//        Session::set('timezone', Input::get('timezone'));
//        Session::set('date', Input::get('date'));
//        Session::set('datetime', Input::get('datetime'));

        $request->session()->put('step3', 'step3');
        $request->session()->put('language', Input::get('language'));
        $request->session()->put('timezone', Input::get('timezone'));
        $request->session()->put('date', Input::get('date'));
        $request->session()->put('datetime', Input::get('datetime'));


        return Redirect::route('configuration');
    }

    /**
     * Get Configuration (step 4)
     * checking prerequisites.
     *
     * @return type view
     */
    public function configuration(Request $request) {
//        dd($request->session()->get('step1'));
        // checking if the installation is running for the first time or not
        if (Config::get('database.install') == '%0%') {
//            if (Session::get('step2') == 'step2') {
            if ($request->session()->get('step2') == 'step2') {
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
    public function configurationcheck(DatabaseRequest $request) {
//        dd($request->session()->get('step1'));
        $request->session()->put('step4', 'step4');
//        Session::set('step4', 'step4');
      
//        Session::set('default', $request->input('default'));
//        Session::set('host', $request->input('host'));
//        Session::set('databasename', $request->input('databasename'));
//        Session::set('username', $request->input('username'));
//        Session::set('password', $request->input('password'));
//        Session::set('port', $request->input('port'));
        
        $request->session()->put('default', $request->input('default'));
        $request->session()->put('host', $request->input('host'));
        $request->session()->put('databasename', $request->input('databasename'));
        $request->session()->put('username', $request->input('username'));
        $request->session()->put('password', $request->input('password'));
        $request->session()->put('port', $request->input('port'));
        

        return Redirect::route('database');
    }

    /**
     * postconnection.
     *
     * @return type view
     */
    public function postconnection(Request $request) {
//        dd($request->session()->get('step1'));

        error_reporting(E_ALL & ~E_NOTICE);
        $default = Input::get('default');
        $host = Input::get('host');
        $database = Input::get('databasename');
        $dbusername = Input::get('username');
        $dbpassword = Input::get('password');
        $port = Input::get('port');

        // Setting environment values
        // $_ENV['DB_TYPE'] = $default;
        // $_ENV['DB_HOST'] = $host;
        // $_ENV['DB_PORT'] = $port;
        // $_ENV['DB_DATABASE'] = $database;
        // $_ENV['DB_USERNAME'] = $dbusername;
        // $_ENV['DB_PASSWORD'] = $dbpassword;

        $ENV['APP_ENV'] = 'local';
        $ENV['APP_DEBUG'] = 'false';
        $ENV['APP_KEY'] = 'SomeRandomString';
        $ENV['APP_BUGSNAG'] = 'true';
        $ENV['APP_URL'] = 'http://localhost';
        $ENV['DB_INSTALL'] = '%0%';
        $ENV['DB_TYPE'] = $default;
        $ENV['DB_HOST'] = $host;
        $ENV['DB_PORT'] = $port;
        $ENV['DB_DATABASE'] = $database;
        $ENV['DB_USERNAME'] = $dbusername;
        $ENV['DB_PASSWORD'] = $dbpassword;
        $ENV['MAIL_DRIVER'] = 'smtp';
        $ENV['MAIL_HOST'] = 'mailtrap.io';
        $ENV['MAIL_PORT'] = '2525';
        $ENV['MAIL_USERNAME'] = 'null';
        $ENV['MAIL_PASSWORD'] = 'null';
        $ENV['CACHE_DRIVER'] = 'file';
        $ENV['SESSION_DRIVER'] = 'file';
        $ENV['QUEUE_DRIVER'] = 'sync';

        $config = '';
        foreach ($ENV as $key => $val) {
            $config .= "{$key}={$val}\n";
        }
        // Write environment file
        $fp = fopen(base_path() . '/.env', 'w');
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
    public function database(Request $request) {
//        dd($request->session());
        // checking if the installation is running for the first time or not
        if (Config::get('database.install') == '%0%') {
//            if (Session::get('step4') == 'step4') {
            if ($request->session()->get('step4') == 'step4') {
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
    public function account(Request $request) {
        // checking if the installation is running for the first time or not
        if (Config::get('database.install') == '%0%') {
//            if (Session::get('step4') == 'step4') {
            if ($request->session()->get('step4') == 'step4') {
//                Session::set('step5', 'step5');
                $request->session()->put('step5', $request->input('step5'));
//                Session::forget('step1');
//                Session::forget('step2');
//                Session::forget('step3');
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
    public function accountcheck(InstallerRequest $request) {
        // checking is the installation was done previously
        try {
            $check_for_pre_installation = System::all();
            if ($check_for_pre_installation) {
                return redirect()->back()->with('fails', 'The data in database already exist. Please provide fresh database');
            }
        } catch (Exception $e) {
            
        }
        if ($request->input('dummy-data') == 'on') {
            $path = base_path() . '/DB/dummy-data.sql';
            // dd($path);
            DB::unprepared(file_get_contents($path));
        } else {
            // migrate database
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);
        }
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
        if ($timezones == null) {
            return redirect()->back()->with('fails', 'Invalid time-zone');
            // return ['response' => 'fail', 'reason' => 'Invalid time-zone', 'status' => '0'];
        }
        // checking requested date time format for the admin and system
        $date_time_format = Date_time_format::where('format', '=', $datetime)->first();
        if ($date_time_format == null) {
            return redirect()->back()->with('fails', 'invalid date-time format');
            // return ['response' => 'fail', 'reason' => 'invalid date-time format', 'status' => '0'];
        }

        // Creating minum settings for system
        $system = new System();
        $system->status = 1;
        $system->department = 1;
        $system->date_time_format = $date_time_format->id;
        $system->time_zone = $timezones->id;
        $version = \Config::get('app.version');
        $version = explode(" ", $version);
        $version = $version[1];
        $system->version = $version;
        $system->save();

        // creating an user
        $user = User::create([
                    'first_name' => $firstname,
                    'last_name' => $lastname,
                    'email' => $email,
                    'user_name' => $username,
                    'password' => Hash::make($password),
                    'assign_group' => 1,
                    'primary_dpt' => 1,
                    'active' => 1,
                    'role' => 'admin',
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
    public function finalize(Request $request) {
        // checking if the installation have been completed or not
//        if (Session::get('step6') == 'step6') {
        if ($request->session()->get('step6') == 'step6') {
            $value = '1';
            $install = base_path() . DIRECTORY_SEPARATOR . '.env';
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
            $link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $pos = strpos($link, 'final');
            $link = substr($link, 0, $pos);
            $app_url = base_path() . DIRECTORY_SEPARATOR . '.env';
            $datacontent2 = File::get($app_url);
            $datacontent2 = str_replace('http://localhost', $link, $datacontent2);
            File::put($app_url, $datacontent2);
            File::put($path22, $content23);
            File::put($path23, $content24);
            try {
                Session::forget('step1');
                Session::forget('step2');
                Session::forget('step3');
                Session::forget('step4');
                Session::forget('step5');
                Session::forget('step6');
                Session::flush();

                Artisan::call('key:generate');

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
    public function finalcheck() {
        try {
            return redirect('/auth/login');
        } catch (Exception $e) {
            return redirect('/auth/login');
        }
    }

    public function changeFilePermission() {
        $path1 = base_path() . DIRECTORY_SEPARATOR . '.env';
        // $path2 = base_path().DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php';
        // $path3 = base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'routes.php';
        // $path4 = base_path().DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'lfm.php';
        if (chmod($path1, 0644)) {
            $f1 = substr(sprintf('%o', fileperms($path1)), -3);
            // $f2 = substr(sprintf('%o', fileperms($path2)), -3);
            // $f3 = substr(sprintf('%o', fileperms($path3)), -3);
            // $f4 = substr(sprintf('%o', fileperms($path4)), -3);
            if ($f1 >= '644') {
                return Redirect::back();
            } else {
                return Redirect::back()->with('fail_to_change', 'We are unable to change file permission on your server please try to change permission manually.');
            }
        } else {
            return Redirect::back()->with('fail_to_change', 'We are unable to change file permission on your server please try to change permission manually.');
        }
    }

    public function jsDisabled() {
        return view('themes/default1/installer/helpdesk/check-js')->with('url', $_SERVER['HTTP_REFERER']);
    }

}
