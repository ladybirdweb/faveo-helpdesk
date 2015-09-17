<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;

/**
 * Sys_userUpdate
 *
 * @package Request
 * @author  Ladybird <info@ladybirdweb.com>
 */
class Sys_userUpdate extends Request {

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
			'email' => 'required|email',
			'phone' => 'size:10',
		];
	}

}
