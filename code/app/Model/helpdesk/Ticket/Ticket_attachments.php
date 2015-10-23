<?php namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_attachments extends Model
{
	protected $table = 'ticket_attachment';
	protected $fillable = [
							'id','thread_id','name','size','type','file','data','poster','updated_at','created_at'
							];
}
