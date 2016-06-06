<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * HelptopicUpdate.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class HelptopicUpdate extends Request
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
            'topic'      => 'required|max:50',
            'department' => 'required',
            'priority'   => 'required',
            'sla_plan'   => 'required',
        ];
    }
}
