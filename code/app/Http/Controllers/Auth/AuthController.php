<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

/* include User Model */
use App\User;

/* Include RegisterRequest */
use Illuminate\Http\Request;

/* Register validation */
use App\Http\Requests\RegisterRequest;

use Hash;

use Mail;

/* Include login validator */
use App\Http\Requests\LoginRequest;


class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/* to redirect after login */
	protected $redirectTo = '/';

	/* Direct After Logout */
	protected $redirectAfterLogout = '/';

	protected $loginPath = '/auth/login';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);


	}
	

	/* Get the form for registration */

	public function getRegister()

    {

        return view('auth.register');

    }

 
    public function postRegister(User $user, RegisterRequest $request)

    {



        $password = Hash::make($request->input('password'));
        $user->password = $password;

        $name = $request->input('full_name');
        $user->name = $name;

        $user->email = $request->input('email');

        // $user->first_name = $request->input('first_name');

        // $user->last_nmae = $request->input('last_nmae');

        // $user->phone_number = $request->input('phone_number');

        // $user->company = $request->input('company');

        $user->role = 'user';

        $code = str_random(60);
		$user->remember_token = $code;

		$user->save();



		
		$mail =  Mail::send('auth.activate',  array('link' => url('getmail', $code), 'username' => $name), function($message) use($user) {
                        $message->to($user->email, $user->full_name)->subject('active your account');
                    });

		return redirect('guest')->with('success','Activate Your Account ! Click on Link that send to your mail');

		
    }

    public function getMail($token, User $user)
    {
    	$user  = $user->where('remember_token',$token)->where('active',0)->first();
    	//dd($user);
    	if($user)
    	{
	    	$user->active = 1;

	    	$user->save();

	    	return redirect('auth/login');

	    }
	    else
	    {
	    	return redirect('auth/login');
	    }


    }

    public function getLogin()
	{
		return view('auth.login');
	}

	/* Post of login page  */
	public function postLogin(LoginRequest $request )
	{
		// $email = $request->input('email');

		// $password = Hash::make($request->input('password'));

		// $remember = $request->input('remember');

		// dd([$email,$password,$remember]);

		$credentials = $request->only('email', 'password');
		
		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			return redirect()->intended($this->redirectPath());
		}
		return redirect($this->loginPath())
					->withInput($request->only('email', 'remember'))
					->withErrors([
						'email' => $this->getFailedLoginMessage(),
						'password'=>$this->getFailedLoginMessage()
					]);


	}

	protected function getFailedLoginMessage()
	{
		return 'This Field do not match our records.';
	}
    

}
