<?php

namespace App\Http\Controllers\Auth;

// controllers
use App\Http\Controllers\Common\PhpMailController;
use App\Http\Controllers\Common\SettingsController;
use App\Http\Controllers\Controller;
// request
use App\User;
// model
// classes
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Lang;

/**
 * PasswordController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class PasswordController extends Controller {

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct(PhpMailController $PhpMailController) {
        $this->PhpMailController = $PhpMailController;
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

            return redirect()->back()->with('status', Lang::get('lang.we_have_e-mailed_your_password_reset_link'));
        } else {
            return redirect()->back()->with('errors', Lang::get("lang.we_can't_find_a_user_with_that_e-mail_address"));
        }
    }

}
