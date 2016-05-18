<?php

namespace App\Model\helpdesk\Ratings;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Rating extends Model
{
     protected $table = 'ratings';
    protected $fillable = [

            'name', 'display_order', 'allow_modification','rating_scale','rating_area','restrict'
                            ];
}
