<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;
use App\Model\helpdesk\Settings\CommonSettings;

/**
 * AgentRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class AgentRequest extends Request
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
            'user_name'  => 'required|unique:users|max:30',
            'first_name' => 'required|max:30',
            // 'last_name'  => 'required|max:30',
            'email'  => 'required|unique:users',
            'active' => 'required',
            // 'account_status' => 'required',
            'group'              => 'required',
            'primary_department' => 'required',
            'agent_time_zone'    => 'required',
            // 'phone_number' => 'phone:IN',
            'mobile' => 'unique:users',
            'team'   => 'required',
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
        if ($settings->status == '1' || $settings->status == 1) {
            return [
                'user_name'  => 'required|unique:users|max:30',
                'first_name' => 'required|max:30',
                // 'last_name'           => 'required|max:30',
                'email'  => 'required|unique:users',
                'active' => 'required',
                // 'account_status'       => 'required',
                'group'              => 'required',
                'primary_department' => 'required',
                'agent_time_zone'    => 'required',
                // 'phone_number' => 'phone:IN',
                // 'mobile' => 'phone:IN',
                'team'         => 'required',
                'mobile'       => 'required|unique:users',
                'country_code' => 'required',
            ];
        } else {
            return 0;
        }
    }
}
