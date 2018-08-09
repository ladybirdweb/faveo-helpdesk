<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * BanlistRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class TickettypeUpdateRequest extends Request
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

        'name'   => 'required|max:20|unique:ticket_type,name,'.$this->segment(2),

            'type_desc'  => 'required|max:30',
            'status'     => 'required',

        ];
    }
}
