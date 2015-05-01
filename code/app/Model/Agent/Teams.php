<?php namespace App\Model\Agent;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
	protected $table = 'teams';
	protected $fillable = 	[
								'name', 'status', 'team_lead', 'assign_alert', 'admin_notes'
							];
}							