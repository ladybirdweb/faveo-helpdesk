<?php

namespace App\Model\helpdesk\Ratings;

use Illuminate\Database\Eloquent\Model;

class RatingRef extends Model
{
     protected $table = 'rating_ref';
    protected $fillable = [

            'rating_id', 'ticket_id', 'thread_id','rating_value'
                            ];
}
