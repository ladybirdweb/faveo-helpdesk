<?php namespace App\Model\Settings;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
	protected $table = 'access';
	protected $fillable = [
							'password_expire', 'reg_method','user_session', 
							'agent_session','reset_ticket_expire', 'password_reset', 
							'bind_agent_ip', 'reg_require', 'quick_access'
							];
}
