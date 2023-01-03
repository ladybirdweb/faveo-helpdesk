<?php

namespace App\Model\helpdesk\Ratings;

use App\BaseModel;

class Rating extends BaseModel
{
    protected $table = 'ratings';

    protected $fillable = [

        'name', 'display_order', 'allow_modification', 'rating_scale', 'rating_area', 'restrict',
    ];
}
