<?php

namespace App\Model\MailJob;

use Illuminate\Database\Eloquent\Model;

class QueueService extends Model
{
    protected $table = 'queue_services';
    protected $fillable = ['name', 'short_name', 'status'];

    public function extraFieldRelation()
    {
        $related = "App\Model\MailJob\FaveoQueue";

        return $this->hasMany($related, 'service_id');
    }

    public function getExtraField($key)
    {
        $value = '';
        $setting = $this->extraFieldRelation()->where('key', $key)->first();
        if ($setting) {
            $value = $setting->value;
        }

        return $value;
    }

    public function getName()
    {
        $name = $this->attributes['name'];
        $id = $this->attributes['id'];
        $html = '<a href='.url('queue/'.$id).'>'.$name.'</a>';

        return $html;
    }

    public function getStatus()
    {
        $status = $this->attributes['status'];
        $html = "<span style='color:red'>Inactive</span>";
        if ($status == 1) {
            $html = "<span style='color:green'>Active</span>";
        }

        return $html;
    }

    public function getAction()
    {
        $id = $this->attributes['id'];
        $status = $this->attributes['status'];
        $html = '<a href='.url('queue/'.$id.'/activate')." class='btn btn-primary'>Activate</a>";
        if ($status == 1) {
            $html = "<a href='#' class='btn btn-primary' disabled>Activate</a>";
        }

        return $html;
    }

    public function isActivate()
    {
        $check = true;
        $settings = $this->extraFieldRelation()->get();
        if ($settings->count() == 0) {
            $check = false;
        }

        return $check;
    }
}
