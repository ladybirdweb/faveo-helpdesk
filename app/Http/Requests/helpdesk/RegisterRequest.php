<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;
use App\Model\helpdesk\Settings\CommonSettings;

/**
 * RegisterRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class RegisterRequest extends Request
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
            'email'                 => 'required|max:50|email|unique:users',
            'full_name'             => 'required',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
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
                'email'                 => 'required|max:50|email|unique:users',
                'full_name'             => 'required',
                'password'              => 'required|min:6',
                'password_confirmation' => 'required|same:password',
                'code'                  => 'required',
                'mobile'                => 'required',
            ];
        } else {
            return 0;
        }
    }
}
