<?php

namespace App\Http\Requests\helpdesk;

use App\Http\Requests\Request;

/**
 * BanlistRequest.
 *
 * @author  Ladybird <info@ladybirdweb.com>
 */
class TickettypeRequest extends Request
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
        if ($this->method() == 'post') {
            $rule = 'unique:ticket_type,name|required|max:25';
        } else {
            $id = $this->name;
            $rule = 'required|max:25|unique:ticket_type,name,'.$id.',id';
        }

        return [
                'name'       => $rule,
                'type_desc'  => 'required|max:30',
                'status'     => 'required',
            ];

        // return [

        //   'name' => 'required|unique:ticket_type|max:20',
        //      // 'name'  => 'required|max:20',
        //     'type_desc'  => 'required|max:30',

        // ];
    }
}
