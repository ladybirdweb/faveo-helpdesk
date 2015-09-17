<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;

/**
 * HelptopicUpdate
 *
 * @package Request
 * @author  Ladybird <info@ladybirdweb.com>
 */
class HelptopicUpdate extends Request {

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
			'parent_topic' => 'required',
			'custom_form' => 'required',
			'department' => 'required',
			'priority' => 'required',
			'sla_plan' => 'required',
			'auto_assign' => 'required',
		];
	}

}
