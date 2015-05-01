<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TemplateRequest extends Request {

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
			'name' => 'required|unique:template',
			'ban_status' => 'required',
			'template_set_to_clone' => 'required',
			'language' => 'required',
		];
	}

}
