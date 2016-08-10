<?php

namespace App\Http\Controllers\Auth;

// controllers
use App\Http\Controllers\Common\PhpMailController;
use App\Http\Controllers\Common\SettingsController;
use App\Http\Controllers\Controller;
// requests
use App\Http\Requests\helpdesk\LoginRequest;
use App\Http\Requests\helpdesk\RegisterRequest;
use App\Http\Requests\helpdesk\OtpVerifyRequest;
use App\Model\helpdesk\Settings\Security;
use App\Model\helpdesk\Settings\CommonSettings;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use App\Model\helpdesk\Ticket\Tickets;
// classes
use App\User;
use App\Model\helpdesk\Utility\Otp;
use Auth;
use DB;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Lang;
use Mail;
use DateTime;
use input;
use Socialite;
use App\Http\Controllers\Admin\helpdesk\SocialMedia\SocialMediaController;

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
class AuthController extends Controller {

    use AuthenticatesAndRegistersUsers;
    /* to redirect after login */

    // if auth is agent
    protected $redirectTo = '/dashboard';
    // if auth is user
    protected $redirectToUser = '/profile';
    /* Direct After Logout */
    protected $redirectAfterLogout = '/';
    protected $loginPath = '/auth/login';
    protected $social;

    /**
     * Create a new authentication controller instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard     $auth
     * @param \Illuminate\Contracts\Auth\Registrar $registrar
     *
     * @return void
     */
    public function __construct(PhpMailController $PhpMailController, SocialMediaController $social) {
        $this->PhpMailController = $PhpMailController;
        $social->configService();
        $this->middleware('guest', ['except' => ['getLogout', 'verifyOTP']]);
    }

    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider) {
        try {
            //notice we are not doing any validation, you should do it

            $user = Socialite::driver($provider)->user();
            if ($user) {
                // stroing data to our use table and logging them in
                $data = [
                    'first_name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'user_name' => $user->getEmail(),
                    'role' => 'user',
                    'active' => 1,
                ];

                Auth::login(User::firstOrCreate($data));
            }
            //after login redirecting to home page
            return redirect('/');
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * Get the form for registration.
     *
     * @return type Response
     */
    public function getRegister(CommonSettings $settings) {
        // Event for login
        $settings = $settings->select('status')->where('option_name', '=', 'send_otp')->first();
        //dd($settings->status);
        \Event::fire(new \App\Events\FormRegisterEvent());
        if (Auth::user()) {
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'agent') {
                return \Redirect::route('dashboard');
            } elseif (Auth::user()->role == 'user') {
                // return view('auth.register');
            }
        } else {
            return view('auth.register', compact('settings'));
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
    public function postRegister(User $user, RegisterRequest $request) {
        $request_array = $request->input();
        $password = Hash::make($request->input('password'));
        $user->password = $password;
        $name = $request->input('full_name');
        $user->first_name = $name;
        $user->user_name = $request->input('email');
        $user->email = $request->input('email');
        if (array_key_exists('mobile', $request_array) && array_key_exists('code', $request_array)) {
            $user->mobile = $request->input('mobile');
            $user->country_code = $request->input('code');
        }
        $user->role = 'user';
        $code = str_random(60);
        $user->remember_token = $code;
        $user->save();
        $settings = CommonSettings::select('status')->where('option_name', '=', 'send_otp')->first();
        $message12 = '';
        $var = $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $name, 'email' => $request->input('email')], $message = ['subject' => null, 'scenario' => 'registration'], $template_variables = ['user' => $name, 'email_address' => $request->input('email'), 'password_reset_link' => url('account/activate/' . $code)]);
        if ($var == null) {
            $message12 = Lang::get('lang.failed_to_send_email_contact_administrator');

            return redirect('home')->with('warning', $message12);
        } else {
            if ($settings->status == 1 || $settings->status == '1') {
                $message12 = Lang::get('lang.activate_your_account_click_on_Link_that_send_to_your_mail_and_moble');
            } else {
                $message12 = Lang::get('lang.activate_your_account_click_on_Link_that_send_to_your_mail');
            }
        }

        // Event for login
        \Event::fire(new \App\Events\LoginEvent($request));
        return redirect('home')->with('success', $message12);
    }

    /**
     * Function to activate account.
     *
     * @param type $token
     *
     * @return type redirect
     */
    public function accountActivate($token) {
        $user = User::where('remember_token', '=', $token)->first();
        $this->openTicketAfterVerification($user->id);
        if ($user) {
            $user->active = 1;
            $user->remember_token = null;
            $user->save();
            return redirect('/auth/login')->with('status', 'Acount activated. Login to start');
        } else {
            return redirect('/auth/login')->with('fails', 'Invalid Token');
        }
    }

    /**
     * Get mail function.
     *
     * @param type      $token
     * @param type User $user
     *
     * @return type Response
     */
    public function getMail($token, User $user) {
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
    public function getLogin() {
        $directory = base_path();
        if (file_exists($directory . DIRECTORY_SEPARATOR . '.env')) {
            if (Auth::user()) {
                if (Auth::user()->role == 'admin' || Auth::user()->role == 'agent') {
                    return \Redirect::route('dashboard');
                } elseif (Auth::user()->role == 'user') {
                    return \Redirect::route('home');
                }
            } else {
                return view('auth.login');
            }
        } else {
            return Redirect::route('licence');
        }
    }

    /**
     * Post of login page.
     *
     * @param type LoginRequest $request
     *
     * @return type Response
     */
    public function postLogin(LoginRequest $request) {
        // dd($request->input());
        \Event::fire('auth.login.event', []); //added 5/5/2016
        // Set login attempts and login time
        $value = $_SERVER['REMOTE_ADDR'];
        $usernameinput = $request->input('email');
        $password = $request->input('password');
        if ($request->input('referer')) {
            $referer = 'form';
        } else {
            $referer = '/';
        }
        $field = filter_var($usernameinput, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
        $result = $this->confirmIPAddress($value, $usernameinput);
        // If attempts > 3 and time < 30 minutes
        $security = Security::whereId('1')->first();
        //dd($security->lockout_message);
        if ($result == 1) {
            return redirect()->back()->withErrors('email', 'Incorrect details')->with(['error' => $security->lockout_message, 'referer' => $referer]);
        }
        //dd($request->input('email'));
        $check_active = User::where('email', '=', $request->input('email'))->orwhere('user_name', '=', $request->input('email'))->first();
        if (!$check_active) {
            return redirect()->back()
                            ->withInput($request->only('email', 'remember'))
                            ->withErrors([
                                'email' => $this->getFailedLoginMessage(),
                                'password' => $this->getFailedLoginMessage(),
                            ])->with(['error' => Lang::get('lang.not-registered'),
                        'referer' => $referer]);
        }
        $settings = CommonSettings::select('status')->where('option_name', '=', 'send_otp')->first();
        if ($settings->status == '0' || $settings->status == 0) {
            if ($check_active->active == 0) {
                return redirect()->back()
                                ->withInput($request->only('email', 'remember'))
                                ->withErrors([
                                    'email' => $this->getFailedLoginMessage(),
                                    'password' => $this->getFailedLoginMessage(),
                                ])->with(['error' => Lang::get('lang.this_account_is_currently_inactive'),
                            'referer' => $referer]);
            }
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
            if ($loginAttempts > $security->backlist_threshold && (time() - $loginAttemptTime <= ($security->lockout_period * 60))) {
                return redirect()->back()->withErrors('email', 'incorrect email')->with('error', $security->lockout_message);
            }
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

        if (Auth::Attempt([$field => $usernameinput, 'password' => $password], $request->has('remember'))) {
            if ($check_active->active == 0) {
                \Auth::logout();
                \Session::flush();
                return \Redirect::route('otp-verification')
                                ->withInput($request->input())
                                ->with(['values' => $request->input(),
                                    'referer' => $referer,
                                    'name' => $check_active->user_name,
                                    'number' => $check_active->mobile]);
            }
            if (Auth::user()->role == 'user') {
                if ($request->input('referer')) {
                    return \Redirect::route($request->input('referer'));
                }
                return \Redirect::route('/');
            } else {
                return redirect()->intended($this->redirectPath());
            }
        }

        return redirect()->back()
                        ->withInput($request->only('email', 'remember'))
                        ->withErrors([
                            'email' => $this->getFailedLoginMessage(),
                            'password' => $this->getFailedLoginMessage(),
                        ])->with(['error' => Lang::get('lang.invalid'),
                    'referer' => $referer]);
        // Increment login attempts
    }

    /**
     * Add login attempt.
     *
     * @param type IPaddress $value
     *
     * @return type Response
     */
    public function addLoginAttempt($value, $field) {
        $result = DB::table('login_attempts')->where('IP', '=', $value)->first();
        $data = $result;
        $security = Security::whereId('1')->first();
        $apt = $security->backlist_threshold;
        if ($data) {
            $attempts = $data->Attempts + 1;
            if ($attempts == $apt) {
//                $result = DB::select('UPDATE login_attempts SET Attempts='.$attempts.", LastLogin=NOW() WHERE IP = '$value' OR User = '$field'");
                $result = DB::table('login_attempts')->where('IP', '=', $value)->orWhere('User', '=', $field)->update(['Attempts' => $attempts, 'LastLogin' => Date('Y-m-d H:i:s')]);
            } else {
                $result = DB::table('login_attempts')->where('IP', '=', $value)->orWhere('User', '=', $field)->update(['Attempts' => $attempts]);
                // $result = DB::select("UPDATE login_attempts SET Attempts=".$attempts." WHERE IP = '$value' OR User = '$field'");
            }
        } else {
//            $result = DB::select("INSERT INTO login_attempts (Attempts,User,IP,LastLogin) values (1,'$field','$value', NOW())");
            $result = DB::table('login_attempts')->update(['Attempts' => 1, 'User' => $field, 'IP' => $value, 'LastLogin' => Date('Y-m-d H:i:s')]);
        }
    }

    /**
     * Clear login attempt.
     *
     * @param type IPaddress $value
     *
     * @return type Response
     */
    public function clearLoginAttempts($value, $field) {
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
    public function confirmIPAddress($value, $field) {
        $security = Security::whereId('1')->first();
        $time = $security->lockout_period;
        $max_attempts = $security->backlist_threshold;
        $table = 'login_attempts';
        $result = DB::select('SELECT Attempts, (CASE when LastLogin is not NULL and DATE_ADD(LastLogin, INTERVAL ' . $time . ' MINUTE)>NOW() then 1 else 0 end) as Denied ' .
                        ' FROM ' . $table . " WHERE IP = '$value' OR User = '$field'");
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
    protected function getFailedLoginMessage() {
        return Lang::get('lang.this_field_do_not_match_our_records');
    }

    public function getVerifyOTP() {
        if (\Session::has('values')) {
            return view('auth.otp-verify');
        } else {
            return redirect('auth/login');
        }
    }

    public function verifyOTP(LoginRequest $request) {
        $user = User::select('id', 'mobile', 'user_name')->where('email', '=', $request->input('email'))->first();
        $otp_length = strlen($request->input('otp'));
        if (($otp_length == 6 && !preg_match("/[a-z]/i", $request->input('otp')))) {
            $otp2 = Hash::make($request->input('otp'));
            $otp = Otp::select('otp', 'updated_at')->where('user_id', '=', $user->id)
                    ->first();
            $date1 = date_format($otp->updated_at, "Y-m-d h:i:sa");
            $date2 = date("Y-m-d h:i:sa");
            $time1 = new DateTime($date2);
            $time2 = new DateTime($date1);
            $interval = $time1->diff($time2);
            if ($interval->i > 30 || $interval->h > 0) {
                $message = Lang::get('lang.otp-expired');
            } else {
                if (Hash::check($request->input('otp'), $otp->otp)) {
                    Otp::where('user_id', '=', $user->id)
                            ->update(['otp' => '']);
                    User::where('id', '=', $user->id)
                            ->update(['active' => 1]);
                    $this->openTicketAfterVerification($user->id);
                    return $this->postLogin($request);
                } else {
                    $message = Lang::get('lang.otp-not-matched');
                }
            }
        } else {
            $message = Lang::get('lang.otp-invalid');
        }
        return \Redirect::route('otp-verification')
                        ->withInput($request->input())
                        ->with(['values' => $request->input(),
                            'number' => $user->mobile,
                            'name' => $user->user_name,
                            'fails' => $message]);
    }

    public function resendOTP(OtpVerifyRequest $request) {
        \Event::fire(new \App\Events\LoginEvent($request));
        return 1;
    }

    /**
     * @category function to change ticket status when user verifies his account
     * @param int $id => user_id
     * @return null
     * @author manish.verma@ladybirdweb.com
     */
    public function openTicketAfterVerification($id) {
        // dd($id);
        $ticket = Tickets::select('id')
                ->where(['user_id' => $id, 'status' => 6])
                ->get();
        Tickets::where(['user_id' => $id, 'status' => 6])
                ->update(['status' => 1]);
        foreach ($ticket as $value) {
            $ticket_id = $value->id;
            Ticket_Thread::where('ticket_id', '=', $ticket_id)
                    ->update(["updated_at" => date('Y-m-d H:i:s')]);
        }
    }

    

}
