<?php namespace App\Model\Utility;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model {

	protected $table	=	'logs';

	protected $fillable	=	['id','level'];

}
