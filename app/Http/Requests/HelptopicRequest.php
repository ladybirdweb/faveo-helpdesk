<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class HelptopicRequest extends Request {

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
			'topic'				=>		'required|unique:help_topic',
			
			'parent_topic'		=>		'required',
			'custom_form'		=>		'required',
			'department'		=>		'required',
			'priority'			=>		'required',
			'sla_plan'			=>		'required',
			'auto_assign'		=>		'required'
		];
	}

}
