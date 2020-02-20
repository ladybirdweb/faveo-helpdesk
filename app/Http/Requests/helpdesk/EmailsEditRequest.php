<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * EmailsEditRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class EmailsEditRequest extends Request
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
            'email_address' => 'email',
            'email_name'    => 'required',
            // 'department' => 'required',
            // 'priority' => 'required',
            // 'help_topic' => 'required',
            // 'imap_config' => 'required',
            'password'  => 'required|min:6',
            'user_name' => 'required',
            // 'sending_host' => 'required',
            // 'sending_port' => 'required',
            //'mailbox_protocol'	=>		'required'
            //            'fetching_host'    => 'required',
            //            'fetching_port'    => 'required',
            //            'mailbox_protocol' => 'required',
        ];
    }
}
