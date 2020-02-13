<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;
use App\Model\helpdesk\Filters\Label;

/**
 * AgentUpdate.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class LableUpdate extends Request
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
        $label_data = \Request::segments();
        $label = Label::find($label_data[1]);

        return [
            'title' => 'required|max:10|unique:labels,title,'.$label->id,
            'color' => 'required|regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'order' => 'required|integer',
        ];
    }
}
