<?php namespace App\Model\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_Priority extends Model
{
	protected $table = 'ticket_priority';
	protected $fillable = [
							'priority_id','priority','priority_desc','priority_color','priority_urgency','ispublic'
							];
}
