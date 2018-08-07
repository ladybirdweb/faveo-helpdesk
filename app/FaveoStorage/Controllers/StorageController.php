<?php

namespace App\FaveoStorage\Controllers;

use App\Http\Controllers\Controller;
use App\Model\helpdesk\Settings\CommonSettings;
use App\Model\helpdesk\Ticket\Ticket_attachments;
use App\Model\helpdesk\Ticket\Ticket_Thread;
use Config;
use Storage;

class StorageController extends Controller
{
    protected $default;
    protected $driver;
    protected $root;
    protected $public_root;
    protected $private_root;
    protected $s3_key;
    protected $s3_region;
    protected $s3_secret;
    protected $s3_bucket;
    protected $rackspace_key;
    protected $rackspace_region;
    protected $rackspace_username;
    protected $rackspace_container;
    protected $rackspace_endpoint;
    protected $rackspace_url_type;

    public function __construct()
    {
        $this->default = $this->defaults();
        $this->driver = $this->driver();
        $this->root = $this->root();
        $this->public_root = $this->root('public-root');
        $this->private_root = $this->root('private-root');
        $this->s3_key = $this->s3Key();
        $this->s3_region = $this->s3Region();
        $this->s3_bucket = $this->s3Bucket();
        $this->rackspace_container = $this->rackspaceContainer();
        $this->rackspace_endpoint = $this->rackspaceEndpoint();
        $this->rackspace_key = $this->rackspaceKey();
        $this->rackspace_region = $this->rackspaceRegion();
        $this->rackspace_url_type = $this->rackspaceUrlType();
        $this->rackspace_username = $this->rackspaceUsername();
    }

    protected function settings($option)
    {
        $settings = new CommonSettings();
        $value = $settings->getOptionValue('storage', $option, true);

        return $value;
    }

    public function defaults()
    {
        $default = 'local';
        if ($this->settings('default')) {
            $default = $this->settings('default');
        }

        return $default;
    }

    public function driver()
    {
        return $this->settings('default');
    }

    public function root($type = 'private-root')
    {
        $root = $this->settings($type);
        if (!$root && $type == 'private-root') {
            $root = storage_path('app/private');
        }
        if (!$root && $type == 'public-root') {
            $root = public_path();
        }
        $carbon = \Carbon\Carbon::now();

        return $root.DIRECTORY_SEPARATOR.$carbon->year.DIRECTORY_SEPARATOR.$carbon->month.DIRECTORY_SEPARATOR.$carbon->day;
    }

    public function s3Key()
    {
        return $this->settings('s3_key');
    }

    public function s3Region()
    {
        return $this->settings('s3_region');
    }

    public function s3Secret()
    {
        return $this->settings('s3_secret');
    }

    public function s3Bucket()
    {
        return $this->settings('s3_bucket');
    }

    public function rackspaceKey()
    {
        return $this->settings('root');
    }

    public function rackspaceRegion()
    {
        return $this->settings('rackspace_region');
    }

    public function rackspaceUsername()
    {
        return $this->settings('rackspace_username');
    }

    public function rackspaceContainer()
    {
        return $this->settings('rackspace_container');
    }

    public function rackspaceEndpoint()
    {
        return $this->settings('rackspace_endpoint');
    }

    public function rackspaceUrlType()
    {
        return $this->settings('rackspace_url_type');
    }

    protected function setFileSystem()
    {
        $config = $this->config();
        //dd($config);
        foreach ($config as $key => $con) {
            if (is_array($con)) {
                foreach ($con as $k => $v) {
                    Config::set("filesystem.$key.$k", $v);
                }
            }
            Config::set("filesystem.$key", $con);
        }

        return Config::get('filesystem');
    }

    protected function config()
    {
        return [
            'default' => $this->default,
            'cloud'   => 's3',
            'disks'   => $this->disks(),
        ];
    }

    protected function disks()
    {
        return [
            'local' => [
                'driver' => 'local',
                'root'   => $this->root.'/attachments',
            ],
            's3' => [
                'driver' => 's3',
                'key'    => $this->s3_key,
                'secret' => $this->s3_secret,
                'region' => $this->s3_region,
                'bucket' => $this->s3_bucket,
            ],
            'rackspace' => [
                'driver'    => 'rackspace',
                'username'  => $this->rackspace_username,
                'key'       => $this->rackspace_key,
                'container' => $this->rackspace_container,
                'endpoint'  => $this->rackspace_endpoint,
                'region'    => $this->rackspace_region,
                'url_type'  => $this->rackspace_url_type,
            ],
        ];
    }

    public function upload($data, $filename, $type, $size, $disposition, $thread_id, $attachment)
    {
        $upload = new Ticket_attachments();
        $name = $upload->whereName($filename)->select('name')->first();

        if ($name) {
            $filename = str_random(5).'_'.$filename;
        }
        $upload->thread_id = $thread_id;
        $upload->name = $filename;
        $upload->type = $type;
        $upload->size = $size;
        $upload->poster = $disposition;
        $upload->driver = $this->default;
        if ($this->default !== 'database') {
            $upload_path = $this->root();
            $upload->path = $upload_path;
            $this->uploadInLocal($attachment, $upload_path, $filename);
        } else {
            $upload->file = $data;
        }
        if ($data && $size && $disposition) {
            $upload->save();
        }

        return $filename;
    }

    public function uploadInLocal($attachment, $upload_path, $filename)
    {
        if (!\File::exists($upload_path)) {
            \File::makeDirectory($upload_path, 0777, true);
        }
        $path = $upload_path.DIRECTORY_SEPARATOR.$filename;
        if (method_exists($attachment, 'getStructure')) {
            $attachment->saveAs($path);
        } else {
            $attachment->move($upload_path, $filename);
        }
    }

    public function saveAttachments($thread_id, $attachments = [], $inline = [])
    {
        if (is_array($attachments) || is_array($inline)) {
            $ticket_thread = Ticket_Thread::find($thread_id);
            if (!$ticket_thread) {
                throw new \Exception('Thread not found');
            }
            $PhpMailController = new \App\Http\Controllers\Common\PhpMailController();
            $NotificationController = new \App\Http\Controllers\Common\NotificationController();
            $ticket_controller = new \App\Http\Controllers\Agent\helpdesk\TicketController($PhpMailController, $NotificationController);
            $thread = $ticket_controller->saveReplyAttachment($ticket_thread, $attachments, $inline);
        }

        return $thread;
    }

    public function saveObjectAttachments($thread_id, $attachment)
    {
        $disposition = 'ATTACHMENT';
        if (is_object($attachment)) {
            if (method_exists($attachment, 'getStructure')) {
                $structure = $attachment->getStructure();
                if (isset($structure->disposition)) {
                    $disposition = $structure->disposition;
                }
                $filename = $attachment->getFileName();
                $type = $attachment->getMimeType();
                $size = $attachment->getSize();
                $data = $attachment->getData();
            } else {
                $filename = $attachment->getClientOriginalName();
                $type = $attachment->getMimeType();
                $size = $attachment->getSize();
                $data = file_get_contents($attachment->getRealPath());
            }
        }

        if ($disposition == 'INLINE' || $disposition == 'inline') {
            $id = str_replace('>', '', str_replace('<', '', $structure->id));
            $body = $thread->body;
            // dd($id,$filename,$body);
            $body = str_replace('cid:'.$id, $filename, $body);
            // dd($body);
            $thread->body = $body;
            $thread->save();
        }

        return $thread;
    }

    public function updateBody($attachment, $thread_id, $filename)
    {
        if (method_exists($attachment, 'getStructure')) {
            $structure = $attachment->getStructure();
            $disposition = 'ATTACHMENT';
            if (isset($structure->disposition)) {
                $disposition = $structure->disposition;
            }

            if ($disposition == 'INLINE' || $disposition == 'inline') {
                $id = str_replace('>', '', str_replace('<', '', $structure->id));
                //dd($disposition,$filename,'cid:' . $id);
                $threads = new Ticket_Thread();
                $thread = $threads->find($thread_id);
                $body = $thread->body;
                $body = str_replace('cid:'.$id, $filename, $body);

                $thread->body = $body;
                $thread->save();

                return $thread;
            }
        }
    }

    public function getFile($drive, $name, $root)
    {
        if ($drive != 'database') {
            $root = $root.'/'.$name;
            if (\File::exists($root)) {
                //chmod($root, 0755);

                return \File::get($root);
            }
        }
    }
}
