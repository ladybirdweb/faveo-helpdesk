<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;
use App\Model\helpdesk\Settings\CommonSettings;

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
        $check = $this->check(new CommonSettings());
        if ($check != 0) {
            return $check;
        }

        return [
            'first_name' => 'required',
            'user_name'  => 'required|min:3|unique:users,user_name',
            'email'      => 'required|unique:users,email',
            'mobile'     => 'unique:users',
        ];
    }

    /**
     *@category Funcion to set rule if send opt is enabled
     *
     *@param  object  $settings (instance of Model common settings)
     *
     *@author manish.verma@ladybirdweb.com
     *
     *@return array|int
     */
    public function check($settings)
    {
        $settings = $settings->select('status')->where('option_name', '=', 'send_otp')->first();
        $email_mandatory = CommonSettings::select('status')->where('option_name', '=', 'email_mandatory')->first();
        if (($settings->status == '1' || $settings->status == 1) && ($email_mandatory->status == '1' || $email_mandatory->status == 1)) {
            return [
                'first_name'   => 'required',
                'user_name'    => 'required|min:3|unique:users,user_name',
                'email'        => 'required|unique:users,email',
                'country_code' => 'required',
                'mobile'       => 'required|unique:users',
            ];
        } elseif (($settings->status == '0' || $settings->status == 0) && ($email_mandatory->status == '1' || $email_mandatory->status == 1)) {
            return 0;
        } elseif (($settings->status == '0' || $settings->status == 0) && ($email_mandatory->status == '0' || $email_mandatory->status == 0)) {
            $rule = $this->onlyMobleRequired();

            return $rule;
        } elseif (($settings->status == '1' || $settings->status == 1) && ($email_mandatory->status == '0' || $email_mandatory->status == 0)) {
            $rule = $this->onlyMobleRequired();

            return $rule;
        } else {
            return 0;
        }
    }

    /**
     *@category function to make only moble required rule
     *
     *@param null
     *
     *@return array
     */
    public function onlyMobleRequired()
    {
        return [
            'first_name'   => 'required',
            'user_name'    => 'required|min:3|unique:users,user_name',
            'email'        => 'unique:users,email',
            'country_code' => 'required',
            'mobile'       => 'required|unique:users',
        ];
    }
}
