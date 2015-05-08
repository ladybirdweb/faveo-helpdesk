<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;

/**
 * SlaUpdate
 *
 * @package Request
 * @author  Ladybird <info@ladybirdweb.com>
 */
class SlaUpdate extends Request {

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
			'grace_period' => 'required',
		];
	}

}
