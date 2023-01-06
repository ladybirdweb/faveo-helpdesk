<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * LoginRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class OtpVerifyRequest extends Request
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
            'email'  => 'required',
            'mobile' => 'required',
        ];
    }
}
