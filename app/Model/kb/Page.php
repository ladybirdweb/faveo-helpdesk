<?php namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

	protected $table = 'pages';
	protected $fillable = ['name', 'slug', 'status', 'visibility', 'description'];

}
