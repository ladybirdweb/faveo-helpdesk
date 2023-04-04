<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

class RatingRequest extends Request
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
            'name'               => 'required|unique:ratings|max:20',
            'display_order'      => 'required|integer',
            'allow_modification' => 'required',
            'rating_scale'       => 'required',
            'rating_area'        => 'required',
            'restrict'           => 'required',
        ];
    }
}
