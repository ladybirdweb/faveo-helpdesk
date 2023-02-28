<?php

namespace App\Model\kb;

use App\BaseModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Define the Model of comment table.
 */
class Comment extends BaseModel
{
    protected $table = 'kb_comment';

    protected $fillable = ['article_id', 'name', 'email', 'website', 'comment', 'status'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strip_tags($value);
    }

    public function setCommentAttribute($value)
    {
        $this->attributes['comment'] = strip_tags($value);
    }

    public function getNameAttribute($value)
    {
        return strip_tags($value);
    }

    public function getCommentAttribute($value)
    {
        return strip_tags($value);
    }
}
