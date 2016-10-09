<?php

namespace App\Http\Requests\helpdesk\Queue;

use App\Http\Requests\Request;

class QueueRequest extends Request
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
        $request = $this->except('_token');
        $rules = $this->setRule($request);

        return $rules;
    }

    public function setRule($request)
    {
        $rules = [];
        if (count($request) > 0) {
            foreach ($request as $key => $value) {
                $rules[$key] = 'required';
            }
        }

        return $rules;
    }
}
