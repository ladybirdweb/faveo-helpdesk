<?php namespace App\Model\Form;

use Illuminate\Database\Eloquent\Model;

class Form_value extends Model {

	protected $table = 'form_value';

	protected $fillable = ['id','values'];

}
