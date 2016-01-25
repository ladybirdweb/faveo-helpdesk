<?php namespace App\Model\helpdesk\Agent;

use Illuminate\Database\Eloquent\Model;

class Group_assign_department extends Model {

	protected $table = 'group_assign_department';

	protected $fillable = ['group_id','department_id'];

}
