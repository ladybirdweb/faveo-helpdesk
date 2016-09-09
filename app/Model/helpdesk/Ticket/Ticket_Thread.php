<?php

namespace App\Model\helpdesk\Ticket;

//use App\BaseModel;
use File;
use Illuminate\Database\Eloquent\Model;

class Ticket_Thread extends Model
{
    protected $table = 'ticket_thread';
    protected $fillable = [
        'id', 'ticket_id', 'staff_id', 'user_id', 'thread_type', 'poster', 'source', 'is_internal', 'title', 'body', 'format', 'ip_address', 'created_at', 'updated_at',
    ];

    public function attach()
    {
        return $this->hasMany('App\Model\helpdesk\Ticket\Ticket_attachments', 'thread_id');
    }

    public function delete()
    {
        $this->attach()->delete();
        parent::delete();
    }

//    public function setTitleAttribute($value) {
//        $this->attributes['title'] = str_replace('"', "'", $value);
//    }

     public function getTitleAttribute($value)
     {
         return str_replace('"', "'", $value);
     }

    public function thread($content)
    {
        //         $porufi = $this->purify($content);
//         dd($content,$porufi);
         return $content;
//         return $this->purify($content);
    }

    public function purify($value)
    {
        require_once base_path('vendor'.DIRECTORY_SEPARATOR.'htmlpurifier'.DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.'HTMLPurifier.auto.php');
        $path = base_path('vendor'.DIRECTORY_SEPARATOR.'htmlpurifier'.DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.'HTMLPurifier'.DIRECTORY_SEPARATOR.'DefinitionCache'.DIRECTORY_SEPARATOR.'Serializer');
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.Trusted', true);
        $config->set('Filter.YouTube', true);
        //$config->set('HTML.Allowed', 'br,img[src],b,a,div,table');
        $purifier = new \HTMLPurifier($config);
        if ($value != strip_tags($value)) {
            $value = $purifier->purify($value);
        }

        return $value;
    }
}
