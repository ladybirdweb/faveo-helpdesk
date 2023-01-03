<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * HelptopicRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class HelptopicRequest extends Request
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
            'topic' => 'required|unique:help_topic|max:50',
            // 'parent_topic' => 'required',
            // 'custom_form' => 'required',
            'department' => 'required',
            'priority'   => 'required',
            'sla_plan'   => 'required',
            // 'auto_assign' => 'required',
        ];
    }
}
