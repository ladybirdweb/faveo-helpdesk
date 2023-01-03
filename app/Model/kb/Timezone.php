<?php

namespace App\Model\kb;

use App\BaseModel;

class Timezone extends BaseModel
{
    protected $table = 'timezones';

    protected $fillable = ['id', 'name', 'location'];
}
