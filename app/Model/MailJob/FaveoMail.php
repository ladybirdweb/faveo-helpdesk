<?php

namespace App\Model\MailJob;

use Illuminate\Database\Eloquent\Model;

class FaveoMail extends Model
{
    protected $table = 'faveo_mails';

    protected $fillable = ['drive', 'key', 'value', 'email_id'];
}
