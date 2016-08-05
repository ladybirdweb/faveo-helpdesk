<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * Sys_userRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class Sys_userRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'    => 'required',
            'user_name'     => 'required|min:3|unique:users,user_name',
            'email'         => 'required|unique:users,email',
        ];
    }
}
