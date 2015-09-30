<?php namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_Collaborator extends Model
{
	protected $table = 'ticket_collaborator';
	protected $fillable = [
							'id','isactive','ticket_id','user_id','role','updated_at','created_at'
							];
}
