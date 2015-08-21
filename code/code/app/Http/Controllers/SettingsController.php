<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Theme\Footer2;
use App\Model\Theme\Footer3;
use App\Model\Theme\Footer4;
use App\Model\Theme\Footer;
use Illuminate\Http\Request;
use App\Http\Requests\SmtpRequest;
use App\Http\Requests;
use App\Model\Email\Smtp;
use Config;
use Input;
use Crypt;


class SettingsController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return type void
	 */
	public function __construct() {
        // $this->smtp();
		$this->middleware('auth');
		$this->middleware('roles');
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
		return view('themes.default1.admin.theme.footer', compact('footer'));
	}

	/**
	 *
	 * @param type Footer $footer
	 * @param type Request $request
	 * @return type response
	 */
	public function PostFooter(Footer $footer, Request $request) {
		$footer = $footer->whereId('1')->first();
		if ($footer->fill($request->input())->save()) {
			return redirect('create-footer')->with('success', 'Footer Created Successfully');
		} else {
			return redirect('create-footer')->with('fails', 'Footer was not createds');
		}

	}
/**
 * get the page to create the footer
 * @return response
 */
	public function CreateFooter2(Footer2 $footer2) {
		$footer2 = $footer2->whereId('1')->first();
		return view('themes.default1.admin.theme.footer2', compact('footer2'));
	}

	/**
	 *
	 * @param type Footer $footer
	 * @param type Request $request
	 * @return type response
	 */
	public function PostFooter2(Footer2 $footer2, Request $request) {
		$footer2 = $footer2->whereId('1')->first();
		if ($footer2->fill($request->input())->save()) {
			return redirect('create-footer2')->with('success', 'Footer Created Successfully');
		} else {
			return redirect('create-footer2')->with('fails', 'Footer was not createds');
		}

	}
/**
 * get the page to create the footer
 * @return response
 */
	public function CreateFooter3(Footer3 $footer3) {
		$footer3 = $footer3->whereId('1')->first();
		return view('themes.default1.admin.theme.footer3', compact('footer3'));
	}

	/**
	 *
	 * @param type Footer $footer
	 * @param type Request $request
	 * @return type response
	 */
	public function PostFooter3(Footer3 $footer3, Request $request) {
		$footer3 = $footer3->whereId('1')->first();
		if ($footer3->fill($request->input())->save()) {
			return redirect('create-footer3')->with('success', 'Footer Created Successfully');
		} else {
			return redirect('create-footer3')->with('fails', 'Footer was not createds');
		}

	}
/**
 * get the page to create the footer
 * @return response
 */
	public function CreateFooter4(Footer4 $footer4) {
		$footer4 = $footer4->whereId('1')->first();
		return view('themes.default1.admin.theme.footer4', compact('footer4'));
	}

	/**
	 *
	 * @param type Footer $footer
	 * @param type Request $request
	 * @return type response
	 */
	public function PostFooter4(Footer4 $footer4, Request $request) {
		$footer4 = $footer4->whereId('1')->first();
		if ($footer4->fill($request->input())->save()) {
			return redirect('create-footer4')->with('success', 'Footer Created Successfully');
		} else {
			return redirect('create-footer4')->with('fails', 'Footer was not createds');
		}
	}

	static function host()
	{
		$set = new Smtp;
		$settings = Smtp::where('id','=','1')->first();
		Config::set('mail.host', $settings->host);
	}

	static function port()
	{
		$set = new Smtp;
		$settings = Smtp::where('id','=','1')->first();
		Config::set('mail.port', intval($settings->port));
	}

	static function from()
	{
		$set = new Smtp;
		$settings = Smtp::where('id','=','1')->first();
		Config::set('mail.from', ['address'=>$settings->email,'name'=>$settings->company_name]);
	}
	static function encryption()
	{
		$set = new Smtp;
		$settings = Smtp::where('id','=','1')->first();
		Config::set('mail.encryption', $settings->encryption);
	}

	static function username()
	{
		$set = new Smtp;
		$settings = Smtp::where('id','=','1')->first();
		Config::set('mail.username', $settings->email);
	}

	static function password()
	{
		$settings = Smtp::first();
		if($settings->password) {
			$pass = $settings->password;
			$password = Crypt::decrypt($pass);
			Config::set('mail.password', $password);
		}
	}

	public function getsmtp(){
		$settings = Smtp::where('id','=','1')->first();
		return view('themes.default1.admin.emails.smtp');
	}

	public function postsmtp(SmtpRequest $request){
		$data = Smtp::where('id','=',1)->first();
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

    static function smtp()
    {
        $settings = Smtp::where('id','=','1')->first();
        if($settings->password) {
	        $password = Crypt::decrypt($settings->password);
	        Config::set('mail.password', $password);           
	        Config::set('mail.username', $settings->email);       
	        Config::set('mail.encryption', $settings->encryption);
	        Config::set('mail.from', ['address'=>$settings->email,'name'=>$settings->name]);     
	        Config::set('mail.port', intval($settings->port));
	        Config::set('mail.host', $settings->host);
	        // dd(Config::get('mail'));
    	}
    }

	public function settings(Smtp $set)
	{
		$settings = $set->where('id','1')->first();
		return view('themes.default1.admin.settings',compact('settings'));
	}

	public function PostSettings(Settings $set, Request $request)
	{
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


}




