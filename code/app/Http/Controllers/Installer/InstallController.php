<?php
namespace App\Http\Controllers\Installer;

// /**
//  * |=======================================================================
//  * |Class: InstallController
//  * |=======================================================================
//  *
//  *  Class to perform the first install operation without this the database
//  *  settings could not be started
//  *
//  *  @package    epaper-pdf
//  *  @subpackage Controller
//  *  @author     Ladybird <info@ladybirdweb.com>
//  *
//  */
class InstallController extends Controller {

//     /**
	//      *  Get Licence (step 1)
	//      *
	//      *  validating licence agreement
	//      */
	// public function licence(){
	//         if(Config::get('database.install')=='%0%')
	//         {
	//         return View::make('themes/ep-install/default1/display/view1');
	//         }
	//         else{
	//         return Redirect::route('account-sign-In');
	//     }
	//     }

//     /**
	//      *  Post Licencecheck
	//      *
	//      *  Validating licence agreement
	//      */
	//     public function licencecheck() {
	//         $accept = (Input::has('accept1')) ? true : false;
	//         if ($accept == 'accept') {
	//             Session::put('step1','step1');
	//             return Redirect::route('prerequisites');
	//         } else {
	//             return Redirect::route('licence')->with('fails', 'Failed! first accept the licence agreeement');
	//         }
	//     }

//     /**
	//      *  Get prerequisites (step 2)
	//      *
	//      *  Checking the extensions enabled required for installing the e-paper pdf
	//      *  without which the project cannot be executed properly
	//      *
	//      */
	//     public function prerequisites() {
	//     if(Config::get('database.install')=='%0%')
	//         {
	//         if(Session::get('step1')=='step1'){
	//             return View::make('themes/ep-install/default1/display/view2');
	//         } else {
	//             return Redirect::route('licence');
	//         }
	//     }
	//     else
	//     {
	//         return Redirect::route('account-sign-In');
	//     }
	//     }

//     /**
	//      *  Post Prerequisitescheck
	//      *
	//      *  checking prerequisites
	//      */
	//     public function prerequisitescheck() {
	//         Session::put('step2','step2');
	//         return Redirect::route('localization');
	//     }

//     /**
	//      *  Get Localization (step 3)
	//      *
	//      *  Requesting user recomended settings for installation
	//      */
	//     public function localization() {
	//         if(Config::get('database.install')=='%0%')
	//         {
	//         if(Session::get('step2')=='step2'){
	//         return View::make('themes/ep-install/default1/display/view3');
	//         } else {
	//         return Redirect::route('prerequisites');
	//         }
	//     }
	//         else{
	//           return Redirect::route('account-sign-In');
	//         }
	//     }

//     /**
	//      *  Post localizationcheck
	//      *
	//      *  checking prerequisites
	//      */
	//     public function localizationcheck() {

//         Session::put('step3','step3');

//         Session::put('language', Input::get('language'));
	//         Session::put('timezone', Input::get('timezone'));
	//         Session::put('date', Input::get('date'));
	//         Session::put('datetime', Input::get('datetime'));

//         return Redirect::route('configuration');
	//     }

//     /**
	//      *  Get Configuration (step 4)
	//      *
	//      *  checking prerequisites
	//      */
	//     public function configuration() {
	//         if(Config::get('database.install')=='%0%')
	//         {
	//         if(Session::get('step3')=='step3'){
	//         return View::make('themes/ep-install/default1/display/view4');
	//         } else {
	//         return Redirect::route('localization');
	//         }
	//     }
	//         else{
	//             return Redirect::route('account-sign-In');
	//         }

//     }

//     /**
	//      *  Post configurationcheck
	//      *
	//      *  checking prerequisites
	//      */
	//     public function configurationcheck() {

//         Session::put('step4','step4');

//         Session::put('default', Input::get('default'));
	//         Session::put('host', Input::get('host'));
	//         Session::put('databasename', Input::get('databasename'));
	//         Session::put('username', Input::get('username'));
	//         Session::put('password', Input::get('password'));

//         return Redirect::route('database');
	//     }

//     /**
	//      *  Get database
	//      *
	//      *  checking prerequisites
	//      */
	//     public function database() {
	//         if(Config::get('database.install')=='%0%')
	//         {
	//         if(Session::get('step4')=='step4'){
	//         return View::make('themes/ep-install/default1/display/view5');
	//         } else {
	//         return Redirect::route('configuration');
	//         }
	//     }
	//         else{
	//             return Redirect::route('account-sign-In');
	//         }

//     }

//     /**
	//      *  Get account
	//      *
	//      *  checking prerequisites
	//      */
	//     public function account() {
	//         if(Config::get('database.install')=='%0%')
	//         {
	//         if(Session::get('step4')=='step4'){
	//         return View::make('themes/ep-install/default1/display/view6');
	//         } else {
	//         return Redirect::route('configuration');
	//         }
	//             }
	//         else{
	//             return Redirect::route('account-sign-In');
	//         }

//     }

//     /**
	//      *  Post accountcheck
	//      *
	//      *  checking prerequisites
	//      */
	//     public function accountcheck() {
	//     //  validation check
	//         $validator = Validator::make(Input::all(), array(
	//                     'firstname'         => 'required|max:20',
	//                     'Lastname'          => 'required|max:20',
	//                     'email'             => 'required|max:50|email',
	//                     'username'          => 'required|max:50|min:3',
	//                     'password'          => 'required|min:6',
	//                     'confirmpassword'   => 'required|same:password'
	//         ));
	//         if ($validator->fails()) {
	//             return Redirect::route('account')
	//                             ->withErrors($validator);
	//         } else {

//             // config/database.php management
	//             $default    = Input::get('default');
	//             $host       = Input::get('host');
	//             $database   = Input::get('databasename');
	//             $dbusername   = Input::get('dbusername');
	//             $dbpassword   = Input::get('dbpassword');

//             // set default value
	//             $path0      = app_path('config/database.php');
	//             $content0   = File::get($path0);
	//             $content0   = str_replace('%default%', $default, $content0);
	//             File::put($path0, $content0);

//             // set host,databasename,username,password
	//             if($default=='mysql')
	//             {
	//             $path = app_path('config/database.php');
	//             $content = File::get($path);
	//             $content = str_replace('%host%', $host, $content);
	//             File::put($path, $content);

//             $path1 = app_path('config/database.php');
	//             $content1 = File::get($path1);
	//             $content1 = str_replace('%database%', $database, $content1);
	//             File::put($path1, $content1);

//             $path2 = app_path('config/database.php');
	//             $content2 = File::get($path2);
	//             $content2 = str_replace('%username%', $dbusername, $content2);
	//             File::put($path2, $content2);

//             $path3 = app_path('config/database.php');
	//             $content3 = File::get($path3);
	//             $content3 = str_replace('%password%', $dbpassword, $content3);
	//             File::put($path3, $content3);
	//             }
	//             elseif($default=='pgsql')
	//             {
	//             $path = app_path('config/database.php');
	//             $content = File::get($path);
	//             $content = str_replace('%host1%', $host, $content);
	//             File::put($path, $content);

//             $path1 = app_path('config/database.php');
	//             $content1 = File::get($path1);
	//             $content1 = str_replace('%database1%', $database, $content1);
	//             File::put($path1, $content1);

//             $path2 = app_path('config/database.php');
	//             $content2 = File::get($path2);
	//             $content2 = str_replace('%username1%', $username, $content2);
	//             File::put($path2, $content2);

//             $path3 = app_path('config/database.php');
	//             $content3 = File::get($path3);
	//             $content3 = str_replace('%password1%', $password, $content3);
	//             File::put($path3, $content3);
	//             }
	//             elseif($default=='sqlsrv')
	//             {
	//             $path = app_path('config/database.php');
	//             $content = File::get($path);
	//             $content = str_replace('%host2%', $host, $content);
	//             File::put($path, $content);

//             $path1 = app_path('config/database.php');
	//             $content1 = File::get($path1);
	//             $content1 = str_replace('%database2%', $database, $content1);
	//             File::put($path1, $content1);

//             $path2 = app_path('config/database.php');
	//             $content2 = File::get($path2);
	//             $content2 = str_replace('%username2%', $username, $content2);
	//             File::put($path2, $content2);

//             $path3 = app_path('config/database.php');
	//             $content3 = File::get($path3);
	//             $content3 = str_replace('%password2%', $password, $content3);
	//             File::put($path3, $content3);
	//             }

//             // migrate database
	//             Artisan::call('migrate', array('--force' => true));
	//             Artisan::call('db:seed', array('--force' => true));

//             // create user
	//             $firstname  = Input::get('firstname');
	//             $lastname   = Input::get('lastname');
	//             $email      = Input::get('email');
	//             $username   = Input::get('username');
	//             $password   = Input::get('password');

//             $language   = Input::get('language');
	//             $timezone   = Input::get('timezone');
	//             $date       = Input::get('date');
	//             $datetime   = Input::get('datetime');

//             $user = User::create(array(
	//                         'firstname'     => $firstname,
	//                         'lastname'      => $lastname,
	//                         'email'         => $email,
	//                         'username'      => $username,
	//                         'password'      => Hash::make($password),
	//                         'authority'     => 'admin',
	//                         'active'        => 1
	//             ));

//             // set option values
	//             $dateformat = Option::where('option_name','=','date_format')->first();
	//             $dateformat->option_value = $date;
	//             $dateformat->save();

//             $datetimeformat = Option::where('option_name','=','date_time_format')->first();
	//             $datetimeformat->option_value = $datetime;
	//             $datetimeformat->save();

//             $timezonestring = Option::where('option_name','=','timezone_string')->first();
	//             $timezonestring->option_value = $timezone;
	//             $timezonestring->save();

//             $language1 = Option::where('option_name','=','language')->first();
	//             $language1->option_value = $language;
	//             $language1->save();

//             if ($user) {

//                 Session::put('step6','step6');

//                 return Redirect::route('final');
	//             }
	//         }
	//     }

//     /**
	//      *  Get finalize
	//      *
	//      *  checking prerequisites
	//      */
	//     public function finalize() {
	//         if(Session::get('step6')=='step6'){

//             $var = "http://".$_SERVER['HTTP_HOST']."/epeper-pdf";

//             $siteurl = Option::where('option_name','=','siteurl')->first();
	//             $siteurl->option_value = $var ;
	//             $siteurl->save();

//             $value='1';
	//                 $install = app_path('config/database.php');
	//                 $datacontent = File::get($install);
	//                 $datacontent = str_replace('%0%', $value, $datacontent);
	//                 File::put($install, $datacontent);
	//         try {
	//         return View::make('themes/ep-install/default1/display/view7');
	//         } catch (Exception $e) {
	//         return Redirect::route('npl');
	//         }
	//         } else {
	//         return Redirect::route('account');
	//         }
	//     }

//     /**
	//      *  Post finalcheck
	//      *
	//      *  checking prerequisites
	//      */
	//     public function finalcheck() {
	//         try
	//         {
	//         return Redirect::route('account-sign-In');
	//         }
	//         catch (Exception $e) {
	//             return Redirect::Route('account-sign-out');
	//         }
	//     }

}
