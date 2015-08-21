<?php namespace App\Model\Utility;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model {

	public $timestamps = false;

	protected $table = 'logs';

	protected $fillable = ['id', 'level'];

}
