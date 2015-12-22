<?php namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $table = 'category';
	protected $fillable = ['id', 'slug', 'name', 'description', 'status', 'parent', 'created_at', 'updated_at'];

}
