<?php namespace App\Model\Agent_panel;

use Illuminate\Database\Eloquent\Model;

class Sys_user extends Model {

	/* define table name  */
	protected $table = 'sys_user';

	/* define fillable fields */
	protected $fillable = ['id','email','full_name','phone','internal_notes'];

}
