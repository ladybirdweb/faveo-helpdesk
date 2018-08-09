<?php

namespace App\Model\helpdesk\Manage;

use App\BaseModel;

class Tickettype extends BaseModel
{
    protected $table = 'ticket_type';
    protected $fillable = [
        'id', 'name', 'status', 'type_desc', 'ispublic', 'is_default', 'created_at', 'updated_at',
    ];

    public function bill()
    {
        return $this->hasOne('App\Bill\Models\BillType', 'type');
    }
}
