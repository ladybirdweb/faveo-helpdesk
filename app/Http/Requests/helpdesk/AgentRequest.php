<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

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
        return [
            'user_name'  => 'required|unique:users|max:30',
            'first_name' => 'required|max:30',
            'last_name'  => 'required|max:30',
            'email'      => 'required|unique:users',
            'active'     => 'required',
            // 'account_status' => 'required',
            'group' => 'required',
            'primary_department'  => 'required',
            'agent_time_zone'  => 'required',
            // 'phone_number' => 'phone:IN',
            // 'mobile' => 'phone:IN',
            'team' => 'required',
        ];
    }
}
