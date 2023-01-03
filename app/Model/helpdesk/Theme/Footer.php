<?php

namespace App\Model\helpdesk\Theme;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $table = 'footer';

    protected $fillable = ['title', 'footer'];
}
