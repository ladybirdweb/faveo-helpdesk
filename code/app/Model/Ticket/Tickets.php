<?php namespace App\Model\Ticket;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
	protected $table = 'tickets';
	protected $fillable = [
							'id','ticket_number','num_sequence','user_id','priority_id','sla','help_topic_id','max_open_ticket','collision_avoid','captcha','status','claim_response','assigned_ticket','answered_ticket','agent_mask','html','client_update','max_file_size','remember_token','created_at','updated_at'
							];
}
