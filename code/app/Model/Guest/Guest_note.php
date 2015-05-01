<?php namespace App\Model\Guest;

use Illuminate\Database\Eloquent\Model;

class Guest_note extends Model {

	protected $table = 'guest_note';

	protected $fillable = ['id','heading','content'];

}
