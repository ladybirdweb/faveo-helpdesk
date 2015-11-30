<?php namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;

class Options extends Model {

	protected $table = 'options';
	protected $fillable = ['option_name', 'option_value', 'created_at', 'updated_at'];

}
