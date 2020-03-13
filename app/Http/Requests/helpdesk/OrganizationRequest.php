<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * OrganizationRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class OrganizationRequest extends Request
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

            'name'    => 'required|unique:organization',
            'website' => 'url',
            // 'phone' => 'size:10',
        ];
    }
}
