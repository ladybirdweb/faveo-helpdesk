<?php

namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Relationship extends BaseModel
{
    /* define the table  */

    protected $table = 'kb_article_relationship';
    /* define fillable fields */
    protected $fillable = ['id', 'category_id', 'article_id'];
}
