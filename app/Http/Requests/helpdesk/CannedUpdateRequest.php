<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * AgentRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class CannedUpdateRequest extends Request
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
            'title'   => 'required|min:2|max:50',
            'message' => 'required',
        ];
    }
}
