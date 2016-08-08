<?php

namespace App\Model\helpdesk\Settings;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model {

    protected $table = "social_media";
    protected $fillable = [
        'provider',
        'key',
        'value',
    ];

    public function getvalueByKey($provider, $key) {
        $value = "";
        if ($key === 'redirect') {
            $value = url('social/login/' . $provider);
        }
        $social = $this->where('provider', $provider)->where('key', $key)->first();
        if ($social) {
            $value = $social->value;
        }

        return $value;
    }

    public function checkActive($provider) {
        $check = "";
        $social = $this->where('provider', $provider)->where('key', 'status')->first();
        if ($social) {
            $value = $social->value;
            if ($value === '1') {
                $check = true;
            } 
        }
        return $check;
    }
    public function checkInactive($provider) {
        $check = "";
        $social = $this->where('provider', $provider)->where('key', 'status')->first();
        if ($social) {
            $value = $social->value;
            if ($value === '0') {
                $check = true;
            } 
        }
        return $check;
    }

}
