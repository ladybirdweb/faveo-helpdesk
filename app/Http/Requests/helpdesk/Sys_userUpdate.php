<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

//use Illuminate\Http\Request as Req;
/**
 * Sys_userUpdate.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class Sys_userUpdate extends Request
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
            'first_name' => 'required',
            'user_name'  => 'required|min:3|unique:users,user_name,'.$this->segment(2),
            'email'      => 'required|email|unique:users,email,'.$this->segment(2),
            'mobile'     => 'unique:users,mobile,'.$this->segment(2),
        ];
    }
}
