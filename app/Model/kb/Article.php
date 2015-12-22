<?php namespace App\Model\kb;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Article extends Model {
	use SearchableTrait;

	/**
	 * Searchable rules.
	 *
	 * @var array
	 */
	protected $searchable = [
		'columns' => [
			'name' => 10,
			'slug' => 10,
			'description' => 10,

		],
	];

	/*  define the table name to get the properties of article model as protected  */
	protected $table = 'article';
	/* define the fillable field in the table */
	protected $fillable = ['name', 'slug', 'description', 'type', 'status'];

}
