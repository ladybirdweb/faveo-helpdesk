<?php namespace App\Model\Form;

use Illuminate\Database\Eloquent\Model;

class Form_details extends Model {

	public $timestamps = false;

	protected $table = 'form_details';

	protected $fillable = ['id', 'label', 'type'];

}
