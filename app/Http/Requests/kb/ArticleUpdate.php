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
        //$id = $this->segments()[1];
        $segments = $this->segments();

        $id = isset($segments[1]) ? $segments[1] : null;

        return [
            'name'        => 'required|unique:kb_article,name,'.$id,
            'slug'        => 'required|unique:kb_article,slug,'.$id,
            'description' => 'required',
            'category_id' => 'required',
        ];
    }
}
