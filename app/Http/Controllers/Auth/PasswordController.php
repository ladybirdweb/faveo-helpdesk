<?php

namespace App\Http\Controllers\Auth;

// controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\SettingsController;
use App\Http\Controllers\Common\PhpMailController;
// request
use Illuminate\Http\Request;
// model
use App\User;
// classes
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

/**
 * PasswordController
 *
 * @package     Controllers
 * @subpackage  Controller
 * @author      Ladybird <info@ladybirdweb.com>
 */
class PasswordController extends Controller {

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
     * @return void
     */
    public function __construct(Guard $auth, PasswordBroker $passwords, PhpMailController $PhpMailController) {
        $this->PhpMailController = $PhpMailController;
        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->middleware('guest');
        SettingsController::smtp();
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return Response
     */
    public function getEmail() {
        return view('auth.password');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return Response
     */
    public function postEmail(Request $request) {
        $date = date('Y-m-d H:i:s');
        $this->validate($request, ['email' => 'required|email']);
        $user = User::where('email', '=', $request->only('email'))->first();
        if (isset($user)) {
            $user1 = $user->email;
            //gen new code and pass
            $code = str_random(60);
            $password_reset_table = \DB::table('password_resets')->where('email', '=', $user->email)->first();
            if (isset($password_reset_table)) {

                $password_reset_table = \DB::table('password_resets')->where('email', '=', $user->email)->update(['token' => $code, 'created_at' => $date]);
                // $password_reset_table->token = $code;
                // $password_reset_table->update(['token' => $code]);
            } else {
                $create_password_reset = \DB::table('password_resets')->insert(['email' => $user->email, 'token' => $code, 'created_at' => $date]);
            }

            $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['name' => $user->user_name, 'email' => $user->email], $message = ['subject' => 'Your Password Reset Link', 'scenario' => 'reset-password'], $template_variables = ['user' => $user->user_name, 'email_address' => $user->email, 'password_reset_link' => url('password/reset/' . $code)]);

            return redirect()->back()->with('status', 'We have e-mailed your password reset link!');
        } else {
            return redirect()->back()->with('errors', "We can't find a user with that e-mail address.");
        }
    }

}
