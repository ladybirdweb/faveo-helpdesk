<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * RegisterRequest
 *
 * @package Request
 * @author  Ladybird <info@ladybirdweb.com>
 */
class RegisterRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'email' => 'required|max:50|email|unique:users',
            'full_name' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }

}
