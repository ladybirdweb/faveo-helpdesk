<?php

namespace App\Model\helpdesk\Ticket;

//use App\BaseModel;
use File;
use Illuminate\Database\Eloquent\Model;

class Ticket_Thread extends Model {

    protected $table = 'ticket_thread';
    protected $fillable = [
        'id', 'ticket_id', 'staff_id', 'user_id', 'thread_type', 'poster', 'source', 'is_internal', 'title', 'body', 'format', 'ip_address', 'created_at', 'updated_at',
    ];
    public $notify = true;
    public $send = true;

    public function attach() {
        return $this->hasMany('App\Model\helpdesk\Ticket\Ticket_attachments', 'thread_id');
    }

    public function delete() {
        $this->attach()->delete();
        parent::delete();
    }

//    public function setTitleAttribute($value) {
//        $this->attributes['title'] = str_replace('"', "'", $value);
//    }

    public function getTitleAttribute($value) {
        return str_replace('"', "'", $value);
    }

    public function thread($content) {
        //         $porufi = $this->purify($content);
//         dd($content,$porufi);
        //return $content;
        return $this->purify($content);
    }

    public function purifyOld($value) {
        require_once base_path('vendor' . DIRECTORY_SEPARATOR . 'htmlpurifier' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'HTMLPurifier.auto.php');
        $path = base_path('vendor' . DIRECTORY_SEPARATOR . 'htmlpurifier' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'HTMLPurifier' . DIRECTORY_SEPARATOR . 'DefinitionCache' . DIRECTORY_SEPARATOR . 'Serializer');
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('HTML.Trusted', true);
        $config->set('Filter.YouTube', true);

        $purifier = new \HTMLPurifier($config);
        if ($value != strip_tags($value)) {
            $value = $purifier->purify($value);
        }

        return $value;
    }

    public function purify($inline = true, $mail = "") {
        $value = $this->attributes['body'];
        $str = str_replace("'", '"', $value);
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $str);
        $string = trim(preg_replace('/\s+/', ' ', $html));
        if ($inline) {
            $content = $this->inlineAttachment($string, $mail);
        } else {
            $content = $string;
        }
        return $content;
    }

    public function setTitleAttribute($value) {
        if ($value == '') {
            $this->attributes['title'] = 'No available';
        } else {
            $this->attributes['title'] = $value;
        }
    }

    public function removeScript($html) {
        $doc = new \DOMDocument();

        // load the HTML string we want to strip
        $doc->loadHTML($html);

        // get all the script tags
        $script_tags = $doc->getElementsByTagName('script');

        $length = $script_tags->length;

        // for each tag, remove it from the DOM
        for ($i = 0; $i < $length; $i++) {
            $script_tags->item($i)->parentNode->removeChild($script_tags->item($i));
        }

        // get the HTML string back
        $no_script_html_string = $doc->saveHTML();

        return $no_script_html_string;
    }

    public function firstContent() {
        $poster = $this->attributes['poster'];
        if ($poster == 'client') {
            return 'yes';
        }

        return 'no';
    }

    public function inlineAttachment($body, $mail = "") {

        $attachments = $this->attach;
        if ($attachments->count() > 0) {

            foreach ($attachments as $key => $attach) {
                if ($attach->poster == "INLINE" || $attach->poster == "inline") {
                    $search = $attach->name;
                    if (!$mail) {
                        $replace = "data:$attach->type;base64," . $attach->file;
                    } else {
                        $replace = $mail->embedData(base64_decode($attach->file), $search);
                    }

                    $b = str_replace($search, $replace, $body);
                    $body = $b;
                }
            }
        }
        return $body;
    }

    public function getSubject() {
        $subject = $this->attributes['title'];
        $array = imap_mime_header_decode($subject);
        $title = '';
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $text) {
                $title .= $text->text;
            }

            return wordwrap($title, 70, "<br>\n");
        }

        return wordwrap($subject, 70, "<br>\n");
    }

    public function user() {
        $related = 'App\User';
        $foreignKey = 'user_id';

        return $this->belongsTo($related, $foreignKey);
    }

//    public function setThreadTypeAttribute($value){
//        if (!$value) {
//            $this->thread_type = 'thread';
//        } else {
//            $this->thread_type = $value;
//        }
//    }


    public function save(array $options = array()) {
        $changed = $this->isDirty() ? $this->getDirty() : false;
        $thread_ticket = $this->where('ticket_id', $this->attributes['ticket_id'])->select('id')->first();
        if ($thread_ticket) {
            $this->saveThreadType();
        }
        $id = $this->id;
        $model = $this->find($id);
        $save = parent::save($options);
        if ($this->notify) {
            $ids = $this->id;
            $table = $this->find($ids);
            if ($table && $table->is_internal == 1 && $table->thread_type == 'note') {
                $changed = ['note' => $this->body];
                $model = $table;
            }
            if (checkArray('poster', $changed) == 'client' && checkArray('title', $changed)) {
                $changed = false;
            }
            $array = ['changes' => $changed, 'model' => $model, 'send_mail' => $this->send];
            \Event::fire('notification-saved', [$array]);
        }
        return $save;
    }

    public function saveThreadType() {
        $ticketid = $this->attributes['ticket_id'];
        $thread = $this->where('ticket_id', $ticketid)
                ->where('is_internal', '!=', 1)
                ->where('thread_type', 'first_reply')
                ->where('poster', 'support')
                ->where('title', '')
                ->select('id')
                ->first();
        if (!$thread && checkArray('is_internal', $this->attributes) !== 1) {
            $this->attributes['thread_type'] = 'first_reply';
        }
    }

    public function setUserIdAttributes($value) {
        if ($value) {
            $this->attributes['user_id'] = $value;
        } else {
            $this->attributes['user_id'] = null;
        }
    }

}
