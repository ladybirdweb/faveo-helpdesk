<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * Sys_userRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class WorkflowCreateRequest extends Request
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
            'name'            => 'required|unique:workflow_name,name|max:50',
            'execution_order' => 'required',
            'target_channel'  => 'required',
            'rule'            => 'required',
            'action'          => 'required',
        ];
    }
}
