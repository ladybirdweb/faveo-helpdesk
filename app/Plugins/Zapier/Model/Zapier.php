<?php

namespace App\Plugins\Zapier\Model;

use App\BaseModel;

class Zapier extends BaseModel
{
    protected $table = 'zapier';
    protected $fillable = ['app', 'key', 'value'];

    public function getAppValue($app, $key = '')
    {
        $value = '';
        if ($key == '') {
            return $this->where('app', $app)->get()->toArray();
        }
        $model = $this->where('app', $app)->where('key', $key)->first();
        if ($model) {
            $value = $model->value;
        }

        return $value;
    }

    public function status($app)
    {
        $status = false;
        $value = '';
        $model = $this->where('app', $app)->where('key', 'status')->first();
        if ($model) {
            $value = $model->value;
        }
        if ($value === 'true') {
            $status = true;
        }

        return $status;
    }
}
