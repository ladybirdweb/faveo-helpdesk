<?php namespace App\Http\Controllers\API\helpdesk;
// controllers
use App\Http\Controllers\Controller;
// requests
use Illuminate\Http\Request;
use App\Http\Requests\helpdesk\InstallerRequest;
// models
use App\User;
use App\Model\helpdesk\Settings\System;
use App\Model\helpdesk\Form\Form_details;
// classes
use App;
use Artisan;
use Config;
use File;
use Hash;
use Input;
use Redirect;
use Session;
use View;

/**
 * |=======================================================================
 * |Class: InstallController
 * |=======================================================================
 *
 *  Class to perform the first install operation without this the database
 *  settings could not be started
 *
 *  @package    Faveo HELPDESK
 *  @subpackage Controller
 *  @author     Ladybird <info@ladybirdweb.com>
 *
 */
class InstallerApiController extends Controller {

	/**
	 * config_database
	 * This function is to configure the database and install the application via API call.
	 * @return type Json
	 */
	public function config_database(Request $request) {
		error_reporting(E_ALL & ~E_NOTICE);

		// Check for pre install
		if (\Config::get('database.install') == '%0%') {

			$default 		= 	$request->database;
			$host 			= 	$request->host;
			$database 		= 	$request->databasename;
			$dbusername 	= 	$request->dbusername;
			$dbpassword 	= 	$request->dbpassword;
			$port 			= 	$request->port;

			if(isset($default) && isset($host) && isset($database) && isset($dbusername)){

				// Setting environment values
	 			$_ENV['DB_TYPE'] 		= 	$default;
	        	$_ENV['DB_HOST'] 		= 	$host;
	        	$_ENV['DB_PORT'] 		= 	$port;
	        	$_ENV['DB_DATABASE'] 	= 	$database;
	        	$_ENV['DB_USERNAME'] 	= 	$dbusername;
	        	$_ENV['DB_PASSWORD'] 	= 	$dbpassword;

				$config = '';
	       		foreach ($_ENV as $key => $val) {
	          		$config .= "{$key}={$val}\n";
	        	}

	        	// Write environment file
	        	$fp = fopen(base_path()."/.env", 'w');
	        	fwrite($fp, $config);
	        	fclose($fp);
			
				return ['response'=>'success','status'=>'1'];
			} else {
				return ['response'=>'fail','reason'=>'insufficient parameters','status'=>'0'];
			}
		} else {
			return ['response'=>'fail','reason'=>'this system is already installed','status'=>'0'];								
		}
	}

	/**
	 * config_database
	 * This function is to configure the database and install the application via API call.
	 * @return type Json
	 */
	public function config_system(Request $request) {
		error_reporting(E_ALL & ~E_NOTICE);
		// Check for pre install
		if (\Config::get('database.install') == '%0%') {
			$firstname 	= 	$request->firstname;
	   		$lastname 	= 	$request->lastname;
	   		$email 		= 	$request->email;
	     	$username 	= 	$request->username;
	   		$password 	= 	$request->password;
	   		$timezone 	= 	$request->timezone;
	      	$datetime 	= 	$request->datetime;

			// Migrate database
			Artisan::call('migrate', array('--force' => true));
			Artisan::call('db:seed', array('--force' => true));

			// Creating minum settings
			$system = System::where('id','=','1')->first();
			$system->time_zone = $timezone;
			$system->date_time_format = $datetime;
			$system->save();
			
			// Creating default form field
			$form1 = new Form_details;
			$form1->label = 'Name';
			$form1->type = 'text';
			$form1->form_name_id = '1';
			$form1->save();

			$form2 = new Form_details;
			$form2->label = 'Phone';
			$form2->type = 'number';
			$form2->form_name_id = '1';
			$form2->save();

			$form3 = new Form_details;
			$form3->label = 'Email';
			$form3->type = 'text';
			$form3->form_name_id = '1';
			$form3->save();

			$form4 = new Form_details;
			$form4->label = 'Subject';
			$form4->type = 'text';
			$form4->form_name_id = '1';
			$form4->save();

			$form5 = new Form_details;
			$form5->label = 'Details';
			$form5->type = 'textarea';
			$form5->form_name_id = '1';
			$form5->save();

			// Creating user
			$user = User::create(array(
				'first_name' 	=> 	$firstname,
				'last_name' 	=> 	$lastname,
				'email' 		=> 	$email,
				'user_name' 	=> 	$username,
				'password' 		=> 	Hash::make($password),
				'active' 		=> 	1,
				'role' 			=> 	'admin',
				'assign_group' 	=> 	'group A',
				'primary_dpt' 	=> 	'support',
			));

			// Setting database installed status
			$value 			= 	'1';
			$install 		= 	app_path('../config/database.php');
			$datacontent 	= 	File::get($install);
			$datacontent 	= 	str_replace('%0%', $value, $datacontent);
			File::put($install, $datacontent);

			// Applying email configuration on route
			$smtpfilepath 	= 	"\App\Http\Controllers\Common\SettingsController::smtp()";
			$path22 		= 	app_path('Http/routes.php');
			$content23 		= 	File::get($path22);
			$content23 		= 	str_replace('"%smtplink%"', $smtpfilepath, $content23);
			File::put($path22, $content23);				

			// If user created return success
			if($user){
				return ['response'=>'success','status'=>'1'];					
			}
		} else {
			return ['response'=>'fail','reason'=>'this system is already installed','status'=>'0'];	
		}
	}
}