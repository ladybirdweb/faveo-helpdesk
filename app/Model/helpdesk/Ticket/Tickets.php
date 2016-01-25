<?php namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model {

	protected $table = 'tickets';
	protected $fillable = ['id','ticket_number','num_sequence','user_id','priority_id','sla','help_topic_id','max_open_ticket','captcha','status','lock_by','lock_at','source','isoverdue','reopened','isanswered','is_deleted','closed','is_transfer','transfer_at','reopened_at','duedate','closed_at','last_message_at','last_response_at','created_at','updated_at'];
	
}