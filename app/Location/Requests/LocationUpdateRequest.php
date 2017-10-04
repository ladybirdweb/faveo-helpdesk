<?php
namespace App\Location\Requests;

use App\Http\Requests\Request;

class LocationUpdateRequest extends Request{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
       
        return [
          'title'   => 'required|max:50|unique:location,title,'.$this->segment(4),
           // 'title'=>'required|unique:users',
           'email'=>'required|max:30',
           'address' =>'max:30',
           'phone' =>'max:15'
        ];
    }
}

