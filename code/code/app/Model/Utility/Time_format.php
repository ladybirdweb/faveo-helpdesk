<?php namespace App\Model\Utility;

use Illuminate\Database\Eloquent\Model;

class Time_format extends Model {

	public $timestamps = false;

	protected $table = 'time_format';

	protected $fillable = ['id', 'format'];

}
