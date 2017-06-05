<?php

namespace App\Http\Controllers\Installer\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\DatabaseRequest;
use App\Http\Requests\helpdesk\InstallerRequest;
use App\Model\helpdesk\Settings\System;
// models
use App\Model\helpdesk\Utility\Date_time_format;
use App\Model\helpdesk\Utility\Timezones;
use App\User;
use Artisan;
// classes
use Cache;
use Config;
use DB;
use Exception;
use File;
use Hash;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;
use UnAuth;
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
        $directory = base_path();
        if (file_exists($directory.DIRECTORY_SEPARATOR.'.env')) {
            return redirect('/auth/login');
        } else {
            Cache::flush();
            Artisan::call('config:clear');

            return view('themes/default1/installer/helpdesk/view1');
        }
    }

    /**
     * Post Licencecheck.
     *
     * @return type view
     */
    public function licencecheck(Request $request)
    {
        // checking if the user have accepted the licence agreement
        $accept = (Input::has('accept1')) ? true : false;
        if ($accept == 'accept') {
            Cache::forever('step1', 'step1');

            return Redirect::route('prerequisites');
        } else {
            return Redirect::route('licence')->with('fails', 'Failed! first accept the licence agreeement');
        }
    }

    /**
     * Get prerequisites (step 2).
     *
     * Checking the extensions enabled required for installing the faveo
     * without which the project cannot be executed properly
     *
     * @return type view
     */
    public function prerequisites(Request $request)
    {
        // checking if the installation is running for the first time or not
        if (Cache::get('step1') == 'step1') {
            return View::make('themes/default1/installer/helpdesk/view2');
        } else {
            return Redirect::route('licence');
        }
    }

    /**
     * Post Prerequisitescheck
     * checking prerequisites.
     *
     * @return type view
     */
    public function prerequisitescheck(Request $request)
    {
        Cache::forever('step2', 'step2');

        return Redirect::route('configuration');
    }

    /**
     * Get Localization (step 3)
     * Requesting user recomended settings for installation.
     *
     * @return type view
     */
    public function localization(Request $request)
    {
        // checking if the installation is running for the first time or not
        if (Cache::get('step2') == 'step2') {
            return View::make('themes/default1/installer/helpdesk/view3');
        } else {
            return Redirect::route('prerequisites');
        }
    }

    /**
     * Post localizationcheck
     * checking prerequisites.
     *
     * @return type view
     */
    public function localizationcheck(Request $request)
    {
        Cache::forever('step3', 'step3');

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
    public function configuration(Request $request)
    {
        // checking if the installation is running for the first time or not
        if (Cache::get('step2') == 'step2') {
            return View::make('themes/default1/installer/helpdesk/view3');
        } else {
            return Redirect::route('prerequisites');
        }
    }

    /**
     * Post configurationcheck
     * checking prerequisites.
     *
     * @return type view
     */
    public function configurationcheck(DatabaseRequest $request)
    {
        Cache::forever('step4', 'step4');

        Session::put('default', $request->input('default'));
        Session::put('host', $request->input('host'));
        Session::put('databasename', $request->input('databasename'));
        Session::put('username', $request->input('username'));
        Session::put('password', $request->input('password'));
        Session::put('port', $request->input('port'));

        return Redirect::route('database');
    }

    

    /**
     * Get database
     * checking prerequisites.
     *
     * @return type view
     */
    public function database(Request $request)
    {
        // checking if the installation is running for the first time or not
        if (Cache::get('step4') == 'step4') {
            return View::make('themes/default1/installer/helpdesk/view4');
        } else {
            return Redirect::route('configuration');
        }
    }

    /**
     * Get account
     * checking prerequisites.
     *
     * @return type view
     */
    public function account(Request $request)
    {
        // checking if the installation is running for the first time or not
        if (Cache::get('step4') == 'step4') {
            $request->session()->put('step5', $request->input('step5'));

            return View::make('themes/default1/installer/helpdesk/view5');
        } else {
            return Redirect::route('configuration');
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
    public function accountcheck(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'firstname' => 'required|max:20',
                    'Lastname' => 'required|max:20',
                    'email' => 'required|max:50|email',
                    'username' => 'required|max:50|min:3',
                    'password' => 'required|min:6',
                    'confirmpassword' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect('step5')
                            ->withErrors($validator)
                            ->withInput();
        }
        // checking is the installation was done previously
        // Set variables fetched from input request
        $firstname = $request->input('firstname');
        $lastname = $request->input('Lastname');
        $email = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');

        $language = $request->input('language');
        $timezone = $request->input('timezone');
        $date = $request->input('date');
        $datetime = $request->input('datetime');
        $lang_path = base_path('resources/lang');

        //check user input language package is available or not in the system
        if (array_key_exists($language, \Config::get('languages')) && in_array($language, scandir($lang_path))) {
            // do something here
        } else {
            return \Redirect::back()->with('fails', 'Invalid language');
        }

        $changed = UnAuth::changeLanguage($language);
        if (!$changed) {
            return \Redirect::back()->with('fails', 'Invalid language');
        }
        $version = \Config::get('app.version');
        $version = explode(' ', $version);
        $version = $version[1];
        $system = System::updateOrCreate(['id' => 1], [
                    'status' => 1,
                    'department' => 1,
                    'date_time_format' => $datetime,
                    'time_zone' => $timezone,
                    'version' => $version,
        ]);
        
        // creating an user
        $user = User::updateOrCreate(['id' => 1], [
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
            Cache::forever('step6', 'step6');
            return Redirect::route('final');
        }
    }

    /**
     * Get finalize
     * checking prerequisites.
     *
     * @return type view
     */

    
    public function finalize() {
        // checking if the installation have been completed or not
        if (Cache::get('step6') == 'step6') {
            $language = Cache::get('language');
            try {
                \Cache::flush();
                \Cache::forever('language', $language);
                $this->updateInstalEnv();
                return View::make('themes/default1/installer/helpdesk/view6');
            } catch (Exception $e) {
                return Redirect::route('account')->with('fails', $e->getMessage());
            }
        } else {
            $this->updateInstalEnv();
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
            $this->updateInstalEnv();
            return redirect('/auth/login');
        } catch (Exception $e) {
            return redirect('/auth/login')->with('fails', $e->getMessage());
        }
    }

    public function changeFilePermission()
    {
        $path1 = base_path().DIRECTORY_SEPARATOR.'.env';
        if (chmod($path1, 0644)) {
            $f1 = substr(sprintf('%o', fileperms($path1)), -3);
            if ($f1 >= '644') {
                return Redirect::back();
            } else {
                return Redirect::back()->with('fail_to_change', 'We are unable to change file permission on your server please try to change permission manually.');
            }
        } else {
            return Redirect::back()->with('fail_to_change', 'We are unable to change file permission on your server please try to change permission manually.');
        }
    }

    public function jsDisabled()
    {
        return view('themes/default1/installer/helpdesk/check-js')->with('url', 'step1');
    }
    
    public function createEnv($api = true) {
        try {
            if (Input::get('default')) {
                $default = Input::get('default');
            } else {
                $default = Session::get('default');
            }
            if (Input::get('host')) {
                $host = Input::get('host');
            } else {
                $host = Session::get('host');
            }
            if (Input::get('databasename')) {
                $database = Input::get('databasename');
            } else {
                $database = Session::get('databasename');
            }
            if (Input::get('username')) {
                $dbusername = Input::get('username');
            } else {
                $dbusername = Session::get('username');
            }
            if (Input::get('password')) {
                $dbpassword = Input::get('password');
            } else {
                $dbpassword = Session::get('password');
            }
            if (Input::get('port')) {
                $port = Input::get('port');
            } else {
                $port = Session::get('port');
            }
            $this->env($default, $host, $port, $database, $dbusername, $dbpassword);
        } catch (Exception $ex) {
            $result = ['error' => $ex->getMessage()];
            return response()->json(compact('result'), 500);
        }
        if ($api) {
            $url = url('preinstall/check');
            $result = ['success' => '.env file has been created successfully', 'next' => 'Pre migration test', 'api' => $url];
            return response()->json(compact('result'));
        }
    }

    public function env($default, $host, $port, $database, $dbusername, $dbpassword) {
        $ENV['APP_DEBUG'] = 'true';
        $ENV['APP_BUGSNAG'] = 'false';
        $ENV['APP_URL'] = url('/');
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

        $ENV['FCM_SERVER_KEY'] = 'AIzaSyCyx5OFnsRFUmDLTMbPV50ZMDUGSG-bLw4';
        $ENV['FCM_SENDER_ID'] = '661051343223';

        $config = '';
        foreach ($ENV as $key => $val) {
            $config .= "{$key}={$val}\n";
        }
        if (is_file(base_path() . DIRECTORY_SEPARATOR . '.env')) {
            unlink(base_path() . DIRECTORY_SEPARATOR . '.env');
        }
        if (!is_file(base_path() . DIRECTORY_SEPARATOR . 'example.env')) {
            fopen(base_path() . DIRECTORY_SEPARATOR . 'example.env', "w");
        }

        // Write environment file
        $fp = fopen(base_path() . DIRECTORY_SEPARATOR . 'example.env', 'w');
        fwrite($fp, $config);
        fclose($fp);
        rename(base_path() . DIRECTORY_SEPARATOR . 'example.env', base_path() . DIRECTORY_SEPARATOR . '.env');
    }

    public function checkPreInstall() {
        try {
            $check_for_pre_installation = System::select('id')->first();
            if ($check_for_pre_installation) {

                throw new Exception('The data in database already exist. Please provide fresh database', 100);
            }
        } catch (Exception $ex) {
            if ($ex->getCode() == 100) {
                Artisan::call('droptables');
                $this->createEnv(false);
            }
        }
        Artisan::call('key:generate', ['--force' => true]);

        $url = url('migrate');
        $result = ['success' => 'Pre Migration has been tested successfully', 'next' => 'Migrating DB Tables', 'api' => $url];
        return response()->json(compact('result'));
    }

    public function migrate() {
        try {
            $tableNames = \Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
            if (count($tableNames) === 0) {
                Artisan::call('migrate', ['--force' => true]);
            }
        } catch (Exception $ex) {
            $this->rollBackMigration();
            $result = ['error' => $ex->getMessage()];
            return response()->json(compact('result'), 500);
        }
        $url = url('seed');
        $result = ['success' => 'DB tables have been migrated successfully', 'next' => 'Seeding pre configurations', 'api' => $url];
        return response()->json(compact('result'));
    }

    public function rollBackMigration() {
        try {
            Artisan::call('migrate:reset', ['--force' => true]);
        } catch (Exception $ex) {
            $result = ['error' => $ex->getMessage()];
            return response()->json(compact('result'), 500);
        }
    }

    public function seed(Request $request) {
        try {
            if ($request->input('dummy-data') == 'on') {
                $path = base_path() . '/DB/dummy-data.sql';
                DB::unprepared(DB::raw(file_get_contents($path)));
            } else {
                \Schema::disableForeignKeyConstraints();
                $tableNames = \Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
                foreach ($tableNames as $name) {
                    //if you don't want to truncate migrations
                    if ($name == 'migrations') {
                        continue;
                    }
                    DB::table($name)->truncate();
                }
                Artisan::call('db:seed', ['--force' => true]);
            }
            //$this->updateInstalEnv();
        } catch (Exception $ex) {
            $result = ['error' => $ex->getMessage()];
            return response()->json(compact('result'), 500);
        }
        $result = ['success' => 'installed'];
        return response()->json(compact('result'));
    }

    public function updateInstalEnv() {
        Artisan::call('jwt:generate');

        $env = base_path() . DIRECTORY_SEPARATOR . '.env';
        if (is_file($env)) {
            $txt = "DB_INSTALL=1";
            $txt1 = "APP_ENV=production";
            file_put_contents($env, $txt . PHP_EOL, FILE_APPEND | LOCK_EX);
            file_put_contents($env, $txt1 . PHP_EOL, FILE_APPEND | LOCK_EX);
        } else {
            throw new Exception('.env not found');
        }
    }
}
