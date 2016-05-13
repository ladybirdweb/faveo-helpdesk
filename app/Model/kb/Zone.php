<?php

namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Zone extends BaseModel
{
    protected $table = 'zone';
    protected $fillable = ['zone_id', 'country_code', 'zone_name'];
}
