<?php namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;

/**
 * Define the Model of comment table
 * @package default
 */
class Comment extends Model {

	protected $table = 'comment';
	protected $fillable = ['article_id', 'name', 'email', 'website', 'comment', 'status'];

}
