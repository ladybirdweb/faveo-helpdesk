<?php

namespace App\Model\helpdesk\Theme;

use Illuminate\Database\Eloquent\Model;

class Widgets extends Model {

    protected $table = 'widgets';
    protected $fillable = ['name', 'value', 'created_at', 'updated_at'];

}
