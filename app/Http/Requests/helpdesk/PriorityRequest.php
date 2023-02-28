<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * BanlistRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class PriorityRequest extends Request
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

            'priority'                         => 'required|max:10',
            'status'                           => 'required',
            'priority_desc'                    => 'required|max:255',
            'priority_color'                   => 'required',
            'ispublic'                         => 'required',
            'priority_successfully_updated'    => 'priority successfully updated',
            'priority_successfully_created!!!' => 'priority successfully created',

        ];
    }
}
