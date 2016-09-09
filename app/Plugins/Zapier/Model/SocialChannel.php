<?php

namespace App\Plugins\Zapier\Model;

use App\BaseModel;

class SocialChannel extends BaseModel
{
    protected $table = 'social_channel';
    protected $fillable = ['channel', 'via', 'message_id', 'con_id', 'user_id', 'ticket_id', 'username', 'posted_at'];

    public function getChannelVia($channel, $via, $userid)
    {
        $social = $this->where('channel', $channel)->where('via', $via)->where('user_id', $userid)->first();

        return $social;
    }

    public function getChannelMessageid($channel, $via, $msgid)
    {
        $social = $this->where('channel', $channel)->where('via', $via)->where('message_id', $msgid)->first();

        return $social;
    }

    public function setPostedAtAttribute($value)
    {
        $test = new \DateTime($value);
        $date = date_format($test, 'Y-m-d H:i:s');
        $this->attributes['posted_at'] = $date;
    }

    public function setConIdAttribute($value)
    {
        if ($value == '') {
            $value = null;
        }
        $this->attributes['con_id'] = $value;
    }
}
