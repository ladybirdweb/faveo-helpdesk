<?php namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

	protected $table = 'contact';
	protected $fillable = ['name', 'subject', 'email', 'message'];

}
