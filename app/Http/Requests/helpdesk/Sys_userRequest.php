<?php

namespace App\Http\Requests\helpdesk;
use App\Model\helpdesk\Settings\CommonSettings;

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
        $check = $this->check(new CommonSettings);
        if ($check != 0) {
            return $check;
        }
        return [
            'first_name'    =>  'required',
            'user_name'     =>  'required|min:3|unique:users,user_name',
            'email'         =>  'required|unique:users,email',
        ];
    }

    /**
     *@category Funcion to set rule if send opt is enabled
     *@param Object $settings (instance of Model common settings)
     *@author manish.verma@ladybirdweb.com
     *@return array|int 
     */
    public function check($settings)
    {
        $settings = $settings->select('status')->where('option_name', '=', 'send_otp')->first();
        if ($settings->status == '1' || $settings->status == 1) {
            return [
                'first_name'    =>  'required',
                'user_name'     =>  'required|min:3|unique:users,user_name',
                'email'         =>  'required|unique:users,email',
                'mobile'        =>  'required',
                'country_code'  =>  'required',
            ];
        } else {
            return 0;
        }
    }
}
