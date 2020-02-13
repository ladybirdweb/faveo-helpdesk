<?php

namespace App\Http\Requests\kb;

use App\Http\Requests\Request;

class CategoryRequest extends Request
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
        $id = $this->segment(2);

        return [
            'name'        => 'required|max:250|unique:kb_category,name,'.$id,
            'description' => 'required',
        ];
    }
}
