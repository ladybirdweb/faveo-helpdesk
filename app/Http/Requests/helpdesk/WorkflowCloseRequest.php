<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

class WorkflowCloseRequest extends Request
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
            'days' => 'required|integer|min:1',
            // 'condition'         => 'required|integer',
            'send_email' => 'required|integer',
            'status'     => 'required|integer',
        ];
    }
}
