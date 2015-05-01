<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class Sys_userRequest extends Request {

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
			
			'email' 		=> 	'required|email',
			'full_name'		=>	'required|unique:sys_user',
			'phone'			=>	'size:10'
		];
	}

}
