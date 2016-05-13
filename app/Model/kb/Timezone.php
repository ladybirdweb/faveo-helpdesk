<?php

namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Timezone extends BaseModel
{
    protected $table = 'timezones';
    protected $fillable = ['id', 'name', 'location'];
}
