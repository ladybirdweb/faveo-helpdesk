<?php

namespace App\Model\helpdesk\Utility;

use Illuminate\Database\Eloquent\Model;

class Version_Check extends Model
{
    protected $table = 'version_check';
    protected $fillable = ['current_version', 'new_version', 'updated_at', 'created_at'];
}
