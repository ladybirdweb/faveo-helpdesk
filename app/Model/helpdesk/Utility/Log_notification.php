<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;

class Log_notification extends Model
{
    protected $table = 'log_notification';
    protected $fillable = ['id', 'log'];
}
