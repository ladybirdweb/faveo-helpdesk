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
        $setting = $settings->getOptionValue('storage', $option);
        $value = '';
        if ($setting) {
            $value = $setting->option_value;
        }

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

    public function root()
    {
        $root = storage_path('app');
        if ($this->settings('root')) {
            $root = $this->settings('root');
        }

        return $root;
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
                    Config::set("filesystems.$key.$k", $v);
                }
            }
            Config::set("filesystems.$key", $con);
        }

        return Config::get('filesystems');
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

    public function upload($data, $filename, $type, $size, $disposition, $thread_id)
    {
        $upload = new Ticket_attachments();
        $upload->thread_id = $thread_id;
        $upload->name = $filename;
        $upload->type = $type;
        $upload->size = $size;
        $upload->poster = $disposition;
        $upload->driver = $this->default;
        $upload->path = $this->root.DIRECTORY_SEPARATOR.'attachments';
        if ($this->default !== 'database') {
            $this->setFileSystem();
            Storage::disk($this->default)->put($filename, $data);
            $storagePath = Storage::disk($this->default)->path($filename);
            if (mime(\File::mimeType($storagePath)) != 'image' || mime(\File::extension($storagePath)) != 'image') {
                chmod($storagePath, 1204);
            }
        } else {
            $upload->file = $data;
        }
        if ($data && $size && $disposition) {
            $upload->save();
        }
    }

    public function saveAttachments($thread_id, $attachments = [])
    {
        $disposition = 'ATTACHMENT';
        $thread = '';
        foreach ($attachments as $attachment) {
            if (is_object($attachment)) {
                if (method_exists($attachment, 'getStructure')) {
                    $structure = $attachment->getStructure();
                    if (isset($structure->disposition)) {
                        $disposition = $structure->disposition;
                    }
                    $filename = rand(1111, 9999).'_'.$attachment->getFileName();
                    $type = $attachment->getMimeType();
                    $size = $attachment->getSize();
                    $data = $attachment->getData();
                } else {
                    $filename = rand(1111, 9999).'_'.$attachment->getClientOriginalName();
                    $type = $attachment->getMimeType();
                    $size = $attachment->getSize();
                    $data = file_get_contents($attachment->getRealPath());
                }
                $this->upload($data, $filename, $type, $size, $disposition, $thread_id);
                $thread = $this->updateBody($attachment, $thread_id, $filename);
            }
        }

        return $thread;
    }

    public function updateBody($attachment, $thread_id, $filename)
    {
        $threads = new Ticket_Thread();
        $thread = $threads->find($thread_id);
        $disposition = 'ATTACHMENT';
        if (is_object($attachment)) {
            if (method_exists($attachment, 'getStructure')) {
                $structure = $attachment->getStructure();
                if (isset($structure->disposition)) {
                    $disposition = $structure->disposition;
                }
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

    public function getFile($drive, $name, $root)
    {
        if ($drive != 'database') {
            $root = $root.DIRECTORY_SEPARATOR.$name;
            if (\File::exists($root)) {
                chmod($root, 0755);

                return \File::get($root);
            }
        }
    }
}
