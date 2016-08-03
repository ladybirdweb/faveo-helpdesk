<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * CreateTicketRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class CreateTicketRequest extends Request
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

            'email'     => 'required|email|max:60',
            'user_name'  => 'required|min:3|max:40',
            'helptopic' => 'required',
            // 'dept' => 'required',
            'sla'      => 'required',
            'subject'  => 'required|min:5',
            'body'     => 'required|min:10',
            'priority' => 'required',
        ];
    }
}
