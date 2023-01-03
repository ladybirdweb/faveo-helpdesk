<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class Log_notification extends BaseModel
{
    protected $table = 'log_notification';

    protected $fillable = ['id', 'log'];
}
