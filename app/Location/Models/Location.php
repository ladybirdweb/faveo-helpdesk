<?php

namespace App\Location\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';
    protected $fillable = ['id', 'title', 'email', 'phone', 'address', 'status', 'created_at', 'updated_at'];
}
