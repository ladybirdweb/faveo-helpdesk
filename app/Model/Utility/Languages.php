<?php namespace App\Model\Utility;

use Illuminate\Database\Eloquent\Model;

class Languages extends Model {

	public $timestamps = false;
	
	protected $table = 'languages';

	protected $fillable = ['name', 'locale'];

}
