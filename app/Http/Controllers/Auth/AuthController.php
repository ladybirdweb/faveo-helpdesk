<?php

namespace App\Http\Controllers\Auth;

// controllers
use App\Http\Controllers\Common\PhpMailController;
use App\Http\Controllers\Common\SettingsController;
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\LoginRequest;
use App\Http\Requests\helpdesk\RegisterRequest;
use App\Model\helpdesk\Settings\Security;
// classes
use App\User;
use Auth;
use DB;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Lang;
use Mail;

/**
 * ---------------------------------------------------
 * AuthController
 * ---------------------------------------------------
 * This controller handles the registration of new users, as well as the
 * authentication of existing users. By default, this controller uses
 * a simple trait to add these behaviors. Why don't you explore it?
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers;
    /* to redirect after login */

    // if auth is agent
    protected $redirectTo = '/dashboard';
    // if auth is user
    protected $redirectToUser = '/profile';
    /* Direct After Logout */
    protected $redirectAfterLogout = '/';
    protected $loginPath = '/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard     $auth
     * @param \Illuminate\Contracts\Auth\Registrar $registrar
     *
     * @return void
     */
    public function __construct(PhpMailController $PhpMailController)
    {
        $this->PhpMailController = $PhpMailController;
        SettingsController::smtp();
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get the form for registration.
     *
     * @return type Response
     */
    public function getRegister()
    {
        // Event for login
        \Event::fire(new \App\Events\FormRegisterEvent());
        if (Auth::user()) {
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'agent') {
                return \Redirect::route('dashboard');
            } elseif (Auth::user()->role == 'user') {
                // return view('auth.register');
            }
        } else {
            return view('auth.register');
        }
    }

    /**
     * Post registration form.
     *
     * @param type User            $user
     * @param type RegisterRequest $request
     *
     * @return type Response
     */
    public function postRegister(User $user, RegisterRequest $request)
    {
        // Event for login
        \Event::fire(new \App\Events\LoginEvent($request));
        $password = Hash::make($request->input('password'));
        $user->password = $password;
        $name = $request->input('full_name');
        $user->user_name = $name;
        $user->email = $request->input('email');
        // $user->first_name = $request->input('first_name');
        // $user->last_nmae = $request->input('last_nmae');
        // $user->phone_number = $request->input('phone_number');
        // $user->company = $request->input('company');
        $user->role = 'user';
        $code = str_random(60);
        $user->remember_token = $code;
        $user->save();
        // send mail for successful registration
        // $mail = Mail::send('auth.activate', array('link' => url('getmail', $code), 'username' => $name), function ($message) use ($user) {
        //  $message->to($user->email, $user->full_name)->subject('active your account');
        // });
        $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $name, 'email' => $request->input('email')], $message = ['subject' => 'password', 'scenario' => 'registration-notification'], $template_variables = ['user' => $name, 'email_address' => $request->input('email'), 'password_reset_link' => url('password/reset/'.$code)]);

        return redirect('home')->with('success', Lang::get('lang.activate_your_account_click_on_Link_that_send_to_your_mail'));
    }

    /**
     * Get mail function.
     *
     * @param type      $token
     * @param type User $user
     *
     * @return type Response
     */
    public function getMail($token, User $user)
    {
        $user = $user->where('remember_token', $token)->where('active', 0)->first();
        if ($user) {
            $user->active = 1;
            $user->save();

            return redirect('auth/login');
        } else {
            return redirect('auth/login');
        }
    }

    /**
     * Get login page.
     *
     * @return type Response
     */
    public function getLogin()
    {
        if (Auth::user()) {
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'agent') {
                return \Redirect::route('dashboard');
            } elseif (Auth::user()->role == 'user') {
                return \Redirect::route('home');
            }
        } else {
            return view('auth.login');
        }
    }

    /**
     * Post of login page.
     *
     * @param type LoginRequest $request
     *
     * @return type Response
     */
    public function postLogin(LoginRequest $request)
    {
        // Set login attempts and login time
        $value = $_SERVER['REMOTE_ADDR'];
        $usernameinput = $request->input('email');
        $password = $request->input('password');
        $field = filter_var($usernameinput, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
        $result = $this->confirmIPAddress($value, $usernameinput);
        // If attempts > 3 and time < 30 minutes
        $security = Security::whereId('1')->first();
        //dd($security->lockout_message);
        if ($result == 1) {
            return redirect()->back()->withErrors('email', 'Incorrect details')->with('error', $security->lockout_message);
        }
        //dd($request->input('email'));
        $check_active = User::where('email', '=', $request->input('email'))->orwhere('user_name', '=', $request->input('email'))->first();
        if (!$check_active) {
            return redirect()->back()
                            ->withInput($request->only('email', 'remember'))
                            ->withErrors([
                                'email'    => $this->getFailedLoginMessage(),
                                'password' => $this->getFailedLoginMessage(),
                            ])->with('error', Lang::get('lang.this_account_is_currently_inactive'));
        }
        if ($check_active->active == 0) {
            return redirect()->back()
                            ->withInput($request->only('email', 'remember'))
                            ->withErrors([
                                'email'    => $this->getFailedLoginMessage(),
                                'password' => $this->getFailedLoginMessage(),
                            ])->with('error', Lang::get('lang.this_account_is_currently_inactive'));
        }
        $loginAttempts = 1;
        // If session has login attempts, retrieve attempts counter and attempts time
        if (\Session::has('loginAttempts')) {
            $loginAttempts = \Session::get('loginAttempts');
            $loginAttemptTime = \Session::get('loginAttemptTime');
            $this->addLoginAttempt($value, $usernameinput);
            // $credentials = $request->only('email', 'password');
            $usernameinput = $request->input('email');
            $password = $request->input('password');
            $field = filter_var($usernameinput, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
            // If attempts > 3 and time < 10 minutes
//            if ($loginAttempts > $security->backlist_threshold && (time() - $loginAttemptTime <= ($security->lockout_period * 60))) {
//
//                return redirect()->back()->withErrors('email', 'incorrect email')->with('error', $security->lockout_message);
//            }
            // If time > 10 minutes, reset attempts counter and time in session
            if (time() - $loginAttemptTime > ($security->lockout_period * 60)) {
                \Session::put('loginAttempts', 1);
                \Session::put('loginAttemptTime', time());
            }
        } else { // If no login attempts stored, init login attempts and time
            \Session::put('loginAttempts', $loginAttempts);
            \Session::put('loginAttemptTime', time());
            $this->clearLoginAttempts($value, $usernameinput);
        }
        // If auth ok, redirect to restricted area
        \Session::put('loginAttempts', $loginAttempts + 1);
        \Event::fire('auth.login.event', []); //added 5/5/2016
        if (Auth::Attempt([$field => $usernameinput, 'password' => $password], $request->has('remember'))) {
            if (Auth::user()->role == 'user') {
                return \Redirect::route('/');
            } else {
                return redirect()->intended($this->redirectPath());
            }
        }

        return redirect()->back()
                        ->withInput($request->only('email', 'remember'))
                        ->withErrors([
                            'email'    => $this->getFailedLoginMessage(),
                            'password' => $this->getFailedLoginMessage(),
                        ])->with('error', Lang::get('lang.invalid'));
        // Increment login attempts
    }

    /**
     * Add login attempt.
     *
     * @param type IPaddress $value
     *
     * @return type Response
     */
    public function addLoginAttempt($value, $field)
    {
        $result = DB::table('login_attempts')->where('IP', '=', $value)->first();
        $data = $result;
        $security = Security::whereId('1')->first();
        $apt = $security->backlist_threshold;
        if ($data) {
            $attempts = $data->Attempts + 1;
            if ($attempts == $apt) {
                $result = DB::select('UPDATE login_attempts SET Attempts='.$attempts.", LastLogin=NOW() WHERE IP = '$value' OR User = '$field'");
            } else {
                $result = DB::table('login_attempts')->where('IP', '=', $value)->orWhere('User', '=', $field)->update(['Attempts' => $attempts]);
                // $result = DB::select("UPDATE login_attempts SET Attempts=".$attempts." WHERE IP = '$value' OR User = '$field'");
            }
        } else {
            $result = DB::select("INSERT INTO login_attempts (Attempts,User,IP,LastLogin) values (1,'$field','$value', NOW())");
        }
    }

    /**
     * Clear login attempt.
     *
     * @param type IPaddress $value
     *
     * @return type Response
     */
    public function clearLoginAttempts($value, $field)
    {
        $data = DB::table('login_attempts')->where('IP', '=', $value)->orWhere('User', '=', $field)->update(['attempts' => '0']);

        return $data;
    }

    /**
     * Confiem IP.
     *
     * @param type IPaddress $value
     *
     * @return type Response
     */
    public function confirmIPAddress($value, $field)
    {
        $security = Security::whereId('1')->first();
        $time = $security->lockout_period;
        $max_attempts = $security->backlist_threshold;
        $table = 'login_attempts';
        $result = DB::select('SELECT Attempts, (CASE when LastLogin is not NULL and DATE_ADD(LastLogin, INTERVAL '.$time.' MINUTE)>NOW() then 1 else 0 end) as Denied '.
                        ' FROM '.$table." WHERE IP = '$value' OR User = '$field'");
        $data = $result;
        //Verify that at least one login attempt is in database
        if (!$data) {
            return 0;
        }
        if ($data[0]->Attempts >= $max_attempts) {
            if ($data[0]->Denied == 1) {
                return 1;
            } else {
                $this->clearLoginAttempts($value, $field);

                return 0;
            }
        }

        return 0;
    }

    /**
     * Get Failed login message.
     *
     * @return type string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::get('lang.this_field_do_not_match_our_records');
    }
}
