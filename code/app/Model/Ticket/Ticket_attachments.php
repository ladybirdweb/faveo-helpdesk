<?php namespace App\Model\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_attachments extends Model
{
	protected $table = 'ticket_attachment';
	protected $fillable = [
							'id','thread_id','name','size','type','content','group','updated_at','created_at'
							];
}
