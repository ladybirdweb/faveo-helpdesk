<?php

namespace App\Model\Update;

use App\BaseModel;

class BarNotification extends BaseModel
{
    protected $table = 'bar_notifications';

    protected $fillable = ['key', 'value'];
}
