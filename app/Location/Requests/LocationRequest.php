<?php

namespace App\Location\Requests;

use App\Http\Requests\Request;

class LocationRequest extends Request
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
           'title'   => 'required|unique:location|max:30',
           'email'   => 'required',
           'address' => 'max:30',
           'phone'   => 'max:15',
        ];
    }
}
