<?php namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model {

	protected $table = 'zone';
	protected $fillable = ['zone_id', 'country_code', 'zone_name'];
}