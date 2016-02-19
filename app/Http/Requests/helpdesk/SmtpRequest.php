<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * TicketForm.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class SmtpRequest extends Request
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
            'host'       => 'required',
            'port'       => 'required',
            'encryption' => 'required',
            'name'       => 'required',
            'email'      => 'required',
            'password'   => 'required',
        ];
    }
}
