<?php

namespace App\Model\helpdesk\Agent_panel;

use Illuminate\Database\Eloquent\Model;
//use App\BaseModel;
class Canned extends Model
{
    /* define the table name */

    protected $table = 'canned_response';

    /* Define the fillable fields */
    protected $fillable = ['user_id', 'title', 'message', 'created_at', 'updated_at'];
}
