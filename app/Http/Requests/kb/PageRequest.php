<?php

namespace App\Http\Requests\kb;

use App\Http\Requests\Request;

class PageRequest extends Request
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
        $slug = $this->segment(2);

        return [
            'name' => 'required|unique:kb_pages,slug,'.$slug,
        ];
    }
}
