<?php

namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Social extends BaseModel
{
    protected $table = 'social';
    protected $fillable = ['linkedin', 'stumble', 'google', 'deviantart', 'flickr', 'skype', 'rss', 'twitter', 'facebook', 'youtube', 'vimeo', 'pinterest', 'dribbble', 'instagram'];
}
