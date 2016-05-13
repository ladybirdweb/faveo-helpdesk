<?php

namespace App\Model\helpdesk\Manage;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Forms extends BaseModel
{
    protected $table = 'forms';
    /*
      this is a custom Forms created by user himself
     */
    protected $fillable = ['id', 'title', 'instruction', 'label', 'type', 'visibility', 'variable', 'internal_notes'];
}
