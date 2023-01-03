<?php

namespace App\Model\helpdesk\Ratings;

use App\BaseModel;

class RatingRef extends BaseModel
{
    protected $table = 'rating_ref';

    protected $fillable = [

        'rating_id', 'ticket_id', 'thread_id', 'rating_value',
    ];
}
