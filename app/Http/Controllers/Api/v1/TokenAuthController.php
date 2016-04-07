<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * -----------------------------------------------------------------------------
 * Token authenticate Controller
 * -----------------------------------------------------------------------------.
 *
 *
 * @author Vijay Sebastian <vijay.sebastian@ladybirdweb.com>
 * @copyright (c) 2016, Ladybird Web Solution
 * @name Faveo HELPDESK
 *
 * @version v1
 */
class TokenAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * Authenticating user with username and password and retuen token.
     *
     * @param Request $request
     *
     * @return type json
     */
    public function authenticate(Request $request)
    {
        $usernameinput = $request->input('username');
        $password = $request->input('password');
        $field = filter_var($usernameinput, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

        //$credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt([$field => $usernameinput, 'password' => $password])) {
                return response()->json(['error' => 'invalid_credentials', 'status_code' => 401]);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token', 500]);
        } catch (\Exception $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }

        $user_id = \Auth::user()->id;
        // if no errors are encountered we can return a JWT
        return response()->json(compact('token', 'user_id'));
    }

    /**
     * Get the user details from token.
     *
     * @return type json
     */
    public function getAuthenticatedUser()
    {
        //dd(JWTAuth::parseToken()->authenticate());
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found', 404]);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired', $e->getStatusCode()]);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid', $e->getStatusCode()]);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent', $e->getStatusCode()]);
        } catch (\Exception $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
        //dd($user);
        return response()->json(compact('user'));
    }

    /**
     * Register a user with username and password.
     *
     * @param Request $request
     *
     * @return type json
     */
    public function register(Request $request)
    {
        try {
            $v = \Validator::make($request->all(), [
                        'email'    => 'required|email|unique:users',
                        'password' => 'required',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }
            $newuser = $request->all();
            $password = Hash::make($request->input('password'));

            $newuser['password'] = $password;

            return User::create($newuser);
        } catch (\Exception $e) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }

    /**
     * verify the url is existing or not.
     *
     * @return type json
     */
    public function checkUrl()
    {
        try {
            $v = \Validator::make($request->all(), [
                        'url' => 'required|url',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }

            $url = $this->request->input('url');
            $url = $url.'/api/v1/helpdesk/check-url';
        } catch (Exception $ex) {
            $error = $e->getMessage();

            return response()->json(compact('error'));
        }
    }
}
