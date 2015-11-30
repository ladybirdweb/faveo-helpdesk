<?php namespace App\Http\Controllers\Installer\helpdesk;
// controllers
use App\Http\Controllers\Controller;
// requests
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
class InstallController extends Controller {

	    /**
	     * Get Licence (step 1)
	     * @return type view
	     */
	public function licence() {
			if (Session::get('step5') == 'step5') {
				return Redirect::route('account');
			}

			if (Config::get('database.install') == '%0%') {
				return view('themes/default1/installer/helpdesk/view1');
			} else {
				// return 1;
				return redirect('/auth/login');
			}
	}

	    /**
	     * Post Licencecheck
	     * @return type view
	     */
	public function licencecheck() {
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
	     * Get prerequisites (step 2)
	     * 
	     * Checking the extensions enabled required for installing the faveo
	     * without which the project cannot be executed properly
	     * @return type view
	     */
	public function prerequisites() {
			if (Session::get('step5') == 'step5') {
				return Redirect::route('account');
			}
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
	     * checking prerequisites
	     * @return type view
	     */
	public function prerequisitescheck() {
		Session::put('step2', 'step2');
		return Redirect::route('localization');
	}

	    /**
	     * Get Localization (step 3)
	     * Requesting user recomended settings for installation
	     * @return type view
	     */
	public function localization() {
			if (Session::get('step5') == 'step5') {
				return Redirect::route('account');
			}
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
	     * checking prerequisites
	     * @return type view
	     */
	public function localizationcheck() {

		Session::put('step3', 'step3');

		Session::put('language', Input::get('language'));
		Session::put('timezone', Input::get('timezone'));
		Session::put('date', Input::get('date'));
		Session::put('datetime', Input::get('datetime'));

		return Redirect::route('configuration');
	}

	    /**
	     * Get Configuration (step 4)
	     * checking prerequisites
	     * @return type view
	     */
	public function configuration() {
			if (Session::get('step5') == 'step5') {
				return Redirect::route('account');
			}
			if (Config::get('database.install') == '%0%') {
				if (Session::get('step3') == 'step3') {
					return View::make('themes/default1/installer/helpdesk/view4');
				} else {
					return Redirect::route('localization');
				}
			} else {
				return redirect('/auth/login');
			}
	}

	    /**
	     * Post configurationcheck
	     * checking prerequisites
	     * @return type view
	     */
	public function configurationcheck() {

		Session::put('step4', 'step4');

		Session::put('default', Input::get('default'));
		Session::put('host', Input::get('host'));
		Session::put('databasename', Input::get('databasename'));
		Session::put('username', Input::get('username'));
		Session::put('password', Input::get('password'));

		return Redirect::route('database');
	}

	/**
	 * postconnection
	 * @return type view
	 */
	public function postconnection() {
		
		$default = Input::get('default');
		$host = Input::get('host');
		$database = Input::get('databasename');
		$dbusername = Input::get('username');
		$dbpassword = Input::get('password');
		// set default value
		$path0 = app_path('../config/database.php');
		$content0 = File::get($path0);
		$content0 = str_replace('%default%', $default, $content0);
		File::put($path0, $content0);
		// set host,databasename,username,password
		if ($default == 'mysql') {
			$path = app_path('../config/database.php');
			$content = File::get($path);
			$content = str_replace('%host%', $host, $content);
			File::put($path, $content);

			$path1 = app_path('../config/database.php');
			$content1 = File::get($path1);
			$content1 = str_replace('%database%', $database, $content1);
			File::put($path1, $content1);

			$path2 = app_path('../config/database.php');
			$content2 = File::get($path2);
			$content2 = str_replace('%username%', $dbusername, $content2);
			File::put($path2, $content2);

			$path3 = app_path('../config/database.php');
			$content3 = File::get($path3);
			$content3 = str_replace('%password%', $dbpassword, $content3);
			File::put($path3, $content3);
		} elseif ($default == 'pgsql') {
			$path = app_path('../config/database.php');
			$content = File::get($path);
			$content = str_replace('%host1%', $host, $content);
			File::put($path, $content);

			$path1 = app_path('../config/database.php');
			$content1 = File::get($path1);
			$content1 = str_replace('%database1%', $database, $content1);
			File::put($path1, $content1);

			$path2 = app_path('../config/database.php');
			$content2 = File::get($path2);
			$content2 = str_replace('%username1%', $username, $content2);
			File::put($path2, $content2);

			$path3 = app_path('../config/database.php');
			$content3 = File::get($path3);
			$content3 = str_replace('%password1%', $password, $content3);
			File::put($path3, $content3);
		} elseif ($default == 'sqlsrv') {
			$path = app_path('../config/database.php');
			$content = File::get($path);
			$content = str_replace('%host2%', $host, $content);
			File::put($path, $content);

			$path1 = app_path('../config/database.php');
			$content1 = File::get($path1);
			$content1 = str_replace('%database2%', $database, $content1);
			File::put($path1, $content1);

			$path2 = app_path('../config/database.php');
			$content2 = File::get($path2);
			$content2 = str_replace('%username2%', $username, $content2);
			File::put($path2, $content2);

			$path3 = app_path('../config/database.php');
			$content3 = File::get($path3);
			$content3 = str_replace('%password2%', $password, $content3);
			File::put($path3, $content3);
		}

		return 1;
	}

	    /**
	     * Get database
	     * checking prerequisites
	     * @return type view
	     */
	public function database() {
			if (Config::get('database.install') == '%0%') {
				if (Session::get('step4') == 'step4') {
					return View::make('themes/default1/installer/helpdesk/view5');
				} else {
					return Redirect::route('configuration');
				}
			} else {
				return redirect('/auth/login');
			}
	}

	    /**
	     * Get account
	     * checking prerequisites
	     * @return type view
	     */
	public function account() {
			if (Config::get('database.install') == '%0%') {
				if (Session::get('step4') == 'step4') {
					Session::put('step5', 'step5');
					Session::forget('step1');
					Session::forget('step2');
					Session::forget('step3');
					return View::make('themes/default1/installer/helpdesk/view6');
				} else {
					return Redirect::route('configuration');
				}
			} else {
				return redirect('/auth/login');
			}
	}

	    /**
	     * Post accountcheck
	     * checking prerequisites
	     * @param type InstallerRequest $request 
	     * @return type view
	     */
	public function accountcheck(InstallerRequest $request) {
		// dd($request);
		// config/database.php management
		$default = $request->input('default');
		$host = $request->input('host');
		$database = $request->input('databasename');
		$dbusername = $request->input('dbusername');
		$dbpassword = $request->input('dbpassword');

		// migrate database
		Artisan::call('migrate', array('--force' => true));
		Artisan::call('db:seed', array('--force' => true));

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

		$system = System::where('id','=','1')->first();
		$system->time_zone = $timezone;
		$system->date_time_format = $datetime;
		$system->save();


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

		$user = User::create(array(
			'first_name' => $firstname,
			'last_name' => $lastname,
			'email' => $email,
			'user_name' => $username,
			'password' => Hash::make($password),
			'active' => 1,
			'role' => 'admin',
			'assign_group' => 'group A',
			'primary_dpt' => 'support',
		));

		if ($user) {
			Session::put('step6', 'step6');
			return Redirect::route('final');
		}
	}

	    /**
	     * Get finalize
	     * checking prerequisites
	     * @return type view
	     */
	public function finalize() {
			if (Session::get('step6') == 'step6') {
				// $var = "http://" . $_SERVER['HTTP_HOST'] . "/epeper-pdf";
				// $siteurl = Option::where('option_name', '=', 'siteurl')->first();
				// $siteurl->option_value = $var;
				// $siteurl->save();
				$value = '1';
				$install = app_path('../config/database.php');
				$datacontent = File::get($install);
				$datacontent = str_replace('%0%', $value, $datacontent);
				File::put($install, $datacontent);

				$smtpfilepath = "\App\Http\Controllers\Common\SettingsController::smtp()";
				$path22 = app_path('Http\routes.php');
				$content23 = File::get($path22);
				$content23 = str_replace('"%smtplink%"', $smtpfilepath, $content23);
				File::put($path22, $content23);


				try {
					return View::make('themes/default1/installer/helpdesk/view7');
				} catch (Exception $e) {
					return Redirect::route('npl');
				}
			} else {
				return redirect('/auth/login');
			}
	}

	    /**
	     * Post finalcheck
	     * checking prerequisites
	     * @return type view
	     */
	public function finalcheck() {
		try
		{
			return redirect('/auth/login');
		} catch (Exception $e) {
			return redirect('/auth/login');
		}
	}

}
