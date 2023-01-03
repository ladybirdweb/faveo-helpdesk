<?php

namespace App\Model\helpdesk\Utility;

use App\BaseModel;

class Version_Check extends BaseModel
{
    protected $table = 'version_check';

    protected $fillable = ['current_version', 'new_version', 'updated_at', 'created_at'];
}
