<?php namespace App\Model\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_source extends Model {
	public $timestamps = false;
	protected $table = 'ticket_source';
	protected $fillable = [
		'name','value',
	];
}
