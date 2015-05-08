<?php namespace App\Http\Requests;
use App\Http\Requests\Request;

/**
 * TemplateUdate
 *
 * @package Request
 * @author  Ladybird <info@ladybirdweb.com>
 */
class TemplateUdate extends Request {

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

			'ban_status' => 'required',
			'template_set_to_clone' => 'required',
			'language' => 'required',
		];
	}

}
