<?php

namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ticket_attachments extends Model
{
    protected $table = 'ticket_attachment';

    protected $fillable = [
        'id', 'thread_id', 'name', 'size', 'type', 'file', 'data', 'poster', 'updated_at', 'created_at',
    ];

    public function setFileAttribute($value)
    {
        if ($value) {
            $this->attributes['file'] = base64_encode($value);
        } else {
            $this->attributes['file'] = $value;
        }
    }

    public function getFileAttribute($value)
    {
        $drive = $this->driver;
        $name = $this->name;
        $root = $this->path;

        if (($drive == 'database' || !$drive) && $value && base64_decode($value, true) === false) {
            $value = base64_encode($value);
        }
        if ($drive && $drive !== 'database') {
            $storage = new \App\FaveoStorage\Controllers\StorageController();
            $content = $storage->getFile($drive, $name, $root);
            if ($content) {
                $value = base64_encode($content);
                if (mime($this->type) != 'image') {
                    $root = $root.'/'.$name;
                    chmod($root, 1204);
                }
            }
        }

        return $value;
    }

    public function getFile()
    {
        $size = $this->size;
        $drive = $this->driver;
        $name = $this->name;
        $root = $this->path;
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        $value = number_format($size / pow(1024, $power), 2, '.', ',').' '.$units[$power];
        if ($this->poster == 'ATTACHMENT' || $this->poster == 'attachment') {
            if (mime($this->type) == 'image') {
                $var = '<a href="'.\URL::route('image', ['image_id' => $this->id]).'" target="_blank"><img style="max-width:200px;height:133px;" src="data:image/jpg;base64,'.$this->file.'"/></a>';

                return '<li style="background-color:#f4f4f4;"><span class="mailbox-attachment-icon has-img">'.$var.'</span><div class="mailbox-attachment-info"><b style="word-wrap: break-word;">'.$this->name.'</b><br/><p>'.$value.'</p></div></li>';
            } else {
                $var = '<a style="max-width:200px;height:133px;color:#666;" href="'.\URL::route('image', ['image_id' => $this->id]).'" target="_blank"><span class="mailbox-attachment-icon" style="background-color:#fff; font-size:18px;">'.strtoupper(Str::limit($this->type, 15)).'</span><div class="mailbox-attachment-info"><span ><b style="word-wrap: break-word;">'.$this->name.'</b><br/><p>'.$value.'</p></span></div></a>';

                return '<li style="background-color:#f4f4f4;">'.$var.'</li>';
            }
        }
    }
}
