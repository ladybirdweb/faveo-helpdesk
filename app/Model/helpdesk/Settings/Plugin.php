<?php

namespace App\Model\helpdesk\Settings;

use Illuminate\Database\Eloquent\Model;

class Plugin extends Model {

    protected $table = 'plugins';
    protected $fillable = ['name', 'path', 'status'];

}
