<?php namespace App\Http\Controllers\Installer;

use App;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstallerRequest;
use App\User;
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
	     *  Get Licence (step 1)
	     *
	     *  validating licence agreement
	     */
	public function licence() {
			if (Session::get('step5') == 'step5') {
				return Redirect::route('account');
			}

			if (Config::get('database.install') == '%0%') {
				return view('themes/default1/installer/view1');
			} else {
				// return 1;
				return redirect('/auth/login');
			}
	}

	    /**
	     *  Post Licencecheck
	     *
	     *  Validating licence agreement
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
	     *  Get prerequisites (step 2)
	     *
	     *  Checking the extensions enabled required for installing the faveo
	     *  without which the project cannot be executed properly
	     *
	     */
	public function prerequisites() {
			if (Session::get('step5') == 'step5') {
				return Redirect::route('account');
			}
			if (Config::get('database.install') == '%0%') {
				if (Session::get('step1') == 'step1') {
					return View::make('themes/default1/installer/view2');
				} else {
					return Redirect::route('licence');
				}
			} else {
				return redirect('/auth/login');
			}
	}

	    /**
	     *  Post Prerequisitescheck
	     *
	     *  checking prerequisites
	     */
	public function prerequisitescheck() {
		Session::put('step2', 'step2');
		return Redirect::route('localization');
	}

	    /**
	     *  Get Localization (step 3)
	     *
	     *  Requesting user recomended settings for installation
	     */
	public function localization() {
			if (Session::get('step5') == 'step5') {
				return Redirect::route('account');
			}
			if (Config::get('database.install') == '%0%') {
				if (Session::get('step2') == 'step2') {
					return View::make('themes/default1/installer/view3');
				} else {
					return Redirect::route('prerequisites');
				}
			} else {
				return redirect('/auth/login');
			}
	}

	    /**
	     *  Post localizationcheck
	     *
	     *  checking prerequisites
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
	     *  Get Configuration (step 4)
	     *
	     *  checking prerequisites
	     */
	public function configuration() {
			if (Session::get('step5') == 'step5') {
				return Redirect::route('account');
			}
			if (Config::get('database.install') == '%0%') {
				if (Session::get('step3') == 'step3') {
					return View::make('themes/default1/installer/view4');
				} else {
					return Redirect::route('localization');
				}
			} else {
				return redirect('/auth/login');
			}
	}

	    /**
	     *  Post configurationcheck
	     *
	     *  checking prerequisites
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
	     *  Get database
	     *
	     *  checking prerequisites
	     */
	public function database() {
			if (Config::get('database.install') == '%0%') {
				if (Session::get('step4') == 'step4') {
					return View::make('themes/default1/installer/view5');
				} else {
					return Redirect::route('configuration');
				}
			} else {
				return redirect('/auth/login');
			}
	}

	    /**
	     *  Get account
	     *
	     *  checking prerequisites
	     */
	public function account() {
			if (Config::get('database.install') == '%0%') {
				if (Session::get('step4') == 'step4') {
					Session::put('step5', 'step5');
					Session::forget('step1');
					Session::forget('step2');
					Session::forget('step3');

					return View::make('themes/default1/installer/view6');
				} else {
					return Redirect::route('configuration');
				}
			} else {
				return redirect('/auth/login');
			}
	}

	    /**
	     *  Post accountcheck
	     *
	     *  checking prerequisites
	     */
	public function accountcheck(InstallerRequest $request) {

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

		// set option values
		// $dateformat = Option::where('option_name', '=', 'date_format')->first();
		// $dateformat->option_value = $date;
		// $dateformat->save();

		// $datetimeformat = Option::where('option_name', '=', 'date_time_format')->first();
		// $datetimeformat->option_value = $datetime;
		// $datetimeformat->save();

		// $timezonestring = Option::where('option_name', '=', 'timezone_string')->first();
		// $timezonestring->option_value = $timezone;
		// $timezonestring->save();

		// $language1 = Option::where('option_name', '=', 'language')->first();
		// $language1->option_value = $language;
		// $language1->save();

		if ($user) {

			Session::put('step6', 'step6');

			return Redirect::route('final');
		}
	}

	    /**
	     *  Get finalize
	     *
	     *  checking prerequisites
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
				try {
					return View::make('themes/default1/installer/view7');
				} catch (Exception $e) {
					return Redirect::route('npl');
				}
			} else {
				return redirect('/auth/login');
			}
	}

	    /**
	     *  Post finalcheck
	     *
	     *  checking prerequisites
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
