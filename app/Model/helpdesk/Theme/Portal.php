<?php

namespace App\Model\helpdesk\Theme;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{
    protected $table = 'system_portal';
    protected $fillable = ['id', 'admin_header_color', 'agent_header_color', 'client_header_color', 'client_button_color', 'client_button_border_color', 'client_input_fild_color', 'logo', 'icon', 'created_at', 'updated_at'];
}
