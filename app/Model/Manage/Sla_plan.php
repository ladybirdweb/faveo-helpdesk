<?php namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;

class Sla_plan extends Model
{
	protected $table = 'sla_plan';
	protected $fillable = 	[
								'name', 'grace_period', 'admin_note', 'status', 'transient', 'ticket_overdue'
							];
}							