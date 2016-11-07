<?php

namespace App\Model\helpdesk\Ticket;

use Illuminate\Database\Eloquent\Model;

class Ticket_attachments extends Model
{
    protected $table = 'ticket_attachment';
    protected $fillable = [
                            'id', 'thread_id', 'name', 'size', 'type', 'file', 'data', 'poster', 'updated_at', 'created_at',
                            ];

    public function setFileAttribute($value)
    {
        $this->attributes['file'] = base64_encode($value);
    }

    public function getFile()
    {
        $size = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        $value = number_format($size / pow(1024, $power), 2, '.', ',').' '.$units[$power];
        if ($this->poster == 'ATTACHMENT') {
            if (mime($this->type) == true) {
                $var = '<a href="'.\URL::route('image', ['image_id' => $this->id]).'" target="_blank"><img style="max-width:200px;height:133px;" src="data:image/jpg;base64,'.$this->file.'"/></a>';

                return  '<li style="background-color:#f4f4f4;"><span class="mailbox-attachment-icon has-img">'.$var.'</span><div class="mailbox-attachment-info"><b style="word-wrap: break-word;">'.$this->name.'</b><br/><p>'.$value.'</p></div></li>';
            } else {
                //$var = '<a href="' . URL::route('image', array('image_id' => $attachment->id)) . '" target="_blank"><img style="max-width:200px;height:133px;" src="data:'.$attachment->type.';base64,' . base64_encode($data) . '"/></a>';
                $var = '<a style="max-width:200px;height:133px;color:#666;" href="'.\URL::route('image', ['image_id' => $this->id]).'" target="_blank"><span class="mailbox-attachment-icon" style="background-color:#fff; font-size:18px;">'.strtoupper($this->type).'</span><div class="mailbox-attachment-info"><span ><b style="word-wrap: break-word;">'.$this->name.'</b><br/><p>'.$value.'</p></span></div></a>';

                return  '<li style="background-color:#f4f4f4;">'.$var.'</li>';
            }
        }
    }
}
