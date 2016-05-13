<?php

namespace App\Model\helpdesk\Notification;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Notification extends BaseModel
{
    protected $table = 'notifications';
    protected $fillable = [

            'model_id', 'userid_created', 'type_id',
                            ];
}
