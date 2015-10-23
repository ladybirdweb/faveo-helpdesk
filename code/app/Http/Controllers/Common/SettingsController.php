<?php namespace App\Http\Controllers\Common;
// controllers
use App\Http\Controllers\Controller;
// requests
use Illuminate\Http\Request;
use App\Http\Requests\helpdesk\SmtpRequest;
use App\Http\Requests;
// models
use App\Model\helpdesk\Theme\Footer2;
use App\Model\helpdesk\Theme\Footer3;
use App\Model\helpdesk\Theme\Footer4;
use App\Model\helpdesk\Theme\Footer;
use App\Model\helpdesk\Email\Smtp;
use App\Model\helpdesk\Utility\Version_Check;
// classes
use Config;
use Input;
use Crypt;

/**
 ****************************
 * Settings Controllers
 ****************************
 * Controller to keep smtp details and fetch where ever needed
 * @package default
 */
class SettingsController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type void
	 */
	public function __construct() {
        // $this->smtp();
		$this->middleware('auth');
		$this->middleware('roles');
		SettingsController::driver();
		SettingsController::host();
		SettingsController::port();
		SettingsController::from();
		SettingsController::encryption();
		SettingsController::username();
		SettingsController::password();          
	}

	/**
	 * get the page to create the footer
	 * @return response
	 */
	public function CreateFooter(Footer $footer) {
		$footer = $footer->whereId('1')->first();
		return view('themes.default1.admin.helpdesk.theme.footer', compact('footer'));
	}

	/**
	 * Post footer
	 * @param type Footer $footer
	 * @param type Request $request
	 * @return type response
	 */
	public function PostFooter(Footer $footer, Request $request) {
		$footer = $footer->whereId('1')->first();
		if ($footer->fill($request->input())->save()) {
			return redirect('create-footer')->with('success', 'Footer Saved Successfully');
		} else {
			return redirect('create-footer')->with('fails', 'Footer was not Saved');
		}
	}
	
	/**
	 * get the page to create the footer
	 * @return response
	 */
	public function CreateFooter2(Footer2 $footer2) {
		$footer2 = $footer2->whereId('1')->first();
		return view('themes.default1.admin.helpdesk.theme.footer2', compact('footer2'));
	}

	/**
	 * Post footer 2
	 * @param type Footer $footer
	 * @param type Request $request
	 * @return type response
	 */
	public function PostFooter2(Footer2 $footer2, Request $request) {
		$footer2 = $footer2->whereId('1')->first();
		if ($footer2->fill($request->input())->save()) {
			return redirect('create-footer2')->with('success', 'Footer Saved Successfully');
		} else {
			return redirect('create-footer2')->with('fails', 'Footer was not Saved');
		}
	}

	/**
	 * get the page to create the footer
	 * @return response
	 */
	public function CreateFooter3(Footer3 $footer3) {
		$footer3 = $footer3->whereId('1')->first();
		return view('themes.default1.admin.helpdesk.theme.footer3', compact('footer3'));
	}

	/**
	 * Post footer 3
	 * @param type Footer $footer
	 * @param type Request $request
	 * @return type response
	 */
	public function PostFooter3(Footer3 $footer3, Request $request) {
		$footer3 = $footer3->whereId('1')->first();
		if ($footer3->fill($request->input())->save()) {
			return redirect('create-footer3')->with('success', 'Footer Saved Successfully');
		} else {
			return redirect('create-footer3')->with('fails', 'Footer was not Saved');
		}

	}

	/**
	 * get the page to create the footer
	 * @return response
	 */
	public function CreateFooter4(Footer4 $footer4) {
		$footer4 = $footer4->whereId('1')->first();
		return view('themes.default1.admin.helpdesk.theme.footer4', compact('footer4'));
	}

	/**
	 * Post footer 4
	 * @param type Footer $footer
	 * @param type Request $request
	 * @return type response
	 */
	public function PostFooter4(Footer4 $footer4, Request $request) {
		$footer4 = $footer4->whereId('1')->first();
		if ($footer4->fill($request->input())->save()) {
			return redirect('create-footer4')->with('success', 'Footer Saved Successfully');
		} else {
			return redirect('create-footer4')->with('fails', 'Footer was not Saved');
		}
	}

	/**
	 * Driver
	 * @return type void
	 */
	static function driver() {
		$set = new Smtp;
		$settings = Smtp::where('id','=','1')->first();
		Config::set('mail.host', $settings->driver);
	}

	/**
	 * SMTP host
	 * @return type void
	 */
	static function host() {
		$set = new Smtp;
		$settings = Smtp::where('id','=','1')->first();
		Config::set('mail.host', $settings->host);
	}

	/**
	 * SMTP port
	 * @return type void
	 */
	static function port() {
		$set = new Smtp;
		$settings = Smtp::where('id','=','1')->first();
		Config::set('mail.port', intval($settings->port));
	}

	/**
	 * SMTP from
	 * @return type void
	 */
	static function from() {
		$set = new Smtp;
		$settings = Smtp::where('id','=','1')->first();
		Config::set('mail.from', ['address'=>$settings->email,'name'=>$settings->company_name]);
	}

	/**
	 * SMTP encryption
	 * @return type void
	 */
	static function encryption() {
		$set = new Smtp;
		$settings = Smtp::where('id','=','1')->first();
		Config::set('mail.encryption', $settings->encryption);
	}

	/**
	 * SMTP username
	 * @return type void
	 */
	static function username() {
		$set = new Smtp;
		$settings = Smtp::where('id','=','1')->first();
		Config::set('mail.username', $settings->email);
	}

	/**
	 * SMTP password
	 * @return type void
	 */
	static function password() {
		$settings = Smtp::first();
		if($settings->password) {
			$pass = $settings->password;
			$password = Crypt::decrypt($pass);
			Config::set('mail.password', $password);
		}
	}

	/**
	 * get SMTP
	 * @return type view
	 */
	public function getsmtp(){
		$settings = Smtp::where('id','=','1')->first();
		return view('themes.default1.admin.helpdesk.emails.smtp',compact('settings'));
	}

	/**
	 * POST SMTP
	 * @return type view
	 */
	public function postsmtp(SmtpRequest $request){
		$data = Smtp::where('id','=',1)->first();
		$data->driver = $request->input('driver');
		$data->host = $request->input('host');
		$data->port = $request->input('port');
		$data->encryption = $request->input('encryption');
		$data->name = $request->input('name');
		$data->email = $request->input('email');
		$data->password = Crypt::encrypt($request->input('password'));
		if($data->save()) {
			return \Redirect::route('getsmtp')->with('success','success');	
		} else {
			return \Redirect::route('getsmtp')->with('fails','fails');	
		}
		
	}

	/**
	 * SMTP
	 * @return type void
	 */
    static function smtp() {
        $settings = Smtp::where('id','=','1')->first();
        if($settings->password) {
	        $password = Crypt::decrypt($settings->password);
	        Config::set('mail.driver', $settings->driver);           
	        Config::set('mail.password', $password);           
	        Config::set('mail.username', $settings->email);       
	        Config::set('mail.encryption', $settings->encryption);
	        Config::set('mail.from', ['address'=>$settings->email,'name'=>$settings->name]);     
	        Config::set('mail.port', intval($settings->port));
	        Config::set('mail.host', $settings->host);
    	}
    }

    /**
     * Settings
     * @param type Smtp $set 
     * @return type view\
     */
	public function settings(Smtp $set) {
		$settings = $set->where('id','1')->first();
		return view('themes.default1.admin.settings',compact('settings'));
	}

	/**
	 * Post settings
	 * @param type Settings $set 
	 * @param type Request $request 
	 * @return type view
	 */
	public function PostSettings(Settings $set, Request $request) {
		$settings = $set->where('id','1')->first();
		$pass = $request->input('password');
		$password = Crypt::encrypt($pass);
		$settings->password = $password;
		$settings->save();
		if (Input::file('logo')) {
			$name = Input::file('logo')->getClientOriginalName();
			$destinationPath = 'dist/logo';
			$fileName = rand(0000, 9999) . '.' . $name;
			Input::file('logo')->move($destinationPath, $fileName);
			$settings->logo = $fileName;
			$settings->save();
		}
		$settings->fill($request->except('logo','password'))->save();
		return redirect()->back()->with('success','Settings updated Successfully');
	}

	/**
	 * version_check
	 * @return type
	 */
	public function version_check() {

		$response_url = \URL::route('post-version-check');

		echo "<form action='http://www.faveohelpdesk.com/bill/version' method='post' name='redirect'>";
   		echo "<input type='hidden' name='_token' value='csrf_token()'/>";
   		echo "<input type='hidden' name='title' value='helpdeskcommunityedition'/>";
   		echo "<input type='hidden' name='id' value='19'/>";
   		echo "<input type='hidden' name='response_url' value='".$response_url."' />";
        echo "</form>";
        echo "<script language='javascript'>document.redirect.submit();</script>";

	}

	/**
	 * post_version_check
	 * @return type
	 */
	public function post_version_check(Request $request) {

		$current_version = \Config::get('app.version');

		$new_version = $request->value;

		if($current_version == $new_version) {
			// echo "No, new Updates";
			return redirect()->route('checkupdate')->with('info',' No, new Updates');	
		} elseif($current_version < $new_version) {
			$version = Version_Check::where('id','=','1')->first();
			$version->current_version = $current_version;
			$version->new_version = $new_version;
			$version->save();
			// echo "Version " . $new_version . " is Available";
			return redirect()->route('checkupdate')->with('info',' Version '. $new_version . ' is Available');
		} else {
			// echo "Error Checking Version";
			return redirect()->route('checkupdate')->with('info',' Error Checking Version');
		}

	}

	public function getupdate() {
		return \View::make('themes.default1.admin.helpdesk.settings.checkupdate');
	}
}