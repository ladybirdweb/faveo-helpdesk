<?php namespace App\Model\Utility;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model {

	
	public $timestamps = false;

	protected $table = 'priority';
	protected $fillable = [
				'id', 'name'
	];

}
