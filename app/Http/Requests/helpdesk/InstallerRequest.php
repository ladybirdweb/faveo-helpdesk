<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * InstallerRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class InstallerRequest extends Request
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
            'firstname'       => 'required|max:20',
            'Lastname'        => 'required|max:20',
            'email'           => 'required|max:50|email',
            'username'        => 'required|max:50|min:3',
            'password'        => 'required|min:6',
            'confirmpassword' => 'required|same:password',
        ];
    }
}
