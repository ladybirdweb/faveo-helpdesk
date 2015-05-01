<?php namespace App\Model\Utility;

use Illuminate\Database\Eloquent\Model;

class MailboxProtocol extends Model {

	protected $table  =  'mailbox_protocol';

	protected $fillable = ['id','name' ];

}
