<?php namespace App\Http\Requests\helpdesk;
use App\Http\Requests\Request;

/**
 * AgentUpdate
 *
 * @package Request
 * @author  Ladybird <info@ladybirdweb.com>
 */
class AgentUpdate extends Request {

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
			'last_name' => 'required',
			'email' => 'required|email',
			'active' => 'required',
			'role' => 'required',
			'assign_group' => 'required',
			'primary_dpt' => 'required',
			'agent_tzone' => 'required',
			'phone_number' => 'phone:IN',
			'mobile' => 'phone:IN',
			'team_id' => 'required',
		];
	}

}
