<?php

namespace App\Http\Requests\kb;

use App\Http\Requests\Request;

class ArticleUpdate extends Request
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
        $id = $this->segments()[1];

        return [
            'name'        => 'required',
            'slug'        => 'required|unique:kb_article,slug,'.$id.',id',
            'description' => 'required',
            'category_id' => 'required',
        ];
    }
}
