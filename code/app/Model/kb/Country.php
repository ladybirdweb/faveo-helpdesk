<?php namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

	public $table = 'country';
	protected $fillable = ['country_code', 'country_name'];

}
