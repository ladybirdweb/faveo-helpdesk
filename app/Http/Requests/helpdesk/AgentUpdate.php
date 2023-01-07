<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * AgentUpdate.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class AgentUpdate extends Request
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
            'user_name'  => 'required|max:30|min:3|unique:users,user_name,'.$this->segment(2),
            'first_name' => 'required|max:30',
            // 'last_name'           => 'required|max:30',
            'email'              => 'required|email|unique:users,email,'.$this->segment(2),
            'active'             => 'required',
            'role'               => 'required',
            'group'              => 'required',
            'primary_department' => 'required',
            'agent_time_zone'    => 'required',
            'team'               => 'required',
            'mobile'             => 'unique:users,mobile,'.$this->segment(2),
        ];
    }
}
