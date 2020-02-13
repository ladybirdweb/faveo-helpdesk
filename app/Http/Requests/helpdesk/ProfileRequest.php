<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * ProfileRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class ProfileRequest extends Request
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
            'first_name'  => 'required',
            'profile_pic' => 'mimes:png,jpeg',
            'mobile'      => $this->checkMobile(),
        ];
    }

    /**
     *Check the mobile number is unique or not.
     *
     *@return string
     */
    public function checkMobile()
    {
        if (\Auth::user()->mobile === Request::get('mobile')) {
            return '';
        } else {
            return 'unique:users';
        }
    }
}
