<?php namespace App\Model\Email;

use Illuminate\Database\Eloquent\Model;

class Smtp extends Model
{
	public $timestamps = false;
	protected $table = 'send_mail';
	protected $fillable = 	['port','host','encryption','name','email','password'];
}