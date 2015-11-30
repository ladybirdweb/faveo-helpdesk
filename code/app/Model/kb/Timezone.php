<?php namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model {

	protected $table = 'timezones';
	protected $fillable = ['id', 'name', 'location'];

}
