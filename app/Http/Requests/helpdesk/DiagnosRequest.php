<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * EmailsEditRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class DiagnosRequest extends Request
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
            'from'    => 'required',
            'to'      => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ];
    }
}
