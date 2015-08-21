<?php namespace App\Model\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_Thread extends Model
{
	protected $table = 'ticket_thread';
	protected $fillable = [
							'id','pid','ticket_id','staff_id','user_id','thread_type','poster','source','is_internal','title','body','format','ip_address','created_at','updated_at'
							];
}
