<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;

/**
 * ProfileRequest
 *
 * @package Request
 * @author  Ladybird <info@ladybirdweb.com>
 */
class ProfileRequest extends Request {

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
			'first_name' => 'required',
			'profile_pic' => 'mimes:png,jpeg',
		];
	}

}
