<?php namespace App\Model\Agent;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
	protected $table = 'agents';
	protected $fillable = [	
							'user_name','first_name','last_name','email','phone','mobile','agent_sign', 
							'account_type','account_status','assign_group','primary_dpt','agent_tzone',
							'daylight_save','limit_access','directory_listing','vocation_mode','assign_team'
							];	
}