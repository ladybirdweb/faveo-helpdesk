<?php

namespace App\Model\helpdesk\Settings;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $table = 'social_media';

    protected $fillable = [
        'provider',
        'key',
        'value',
    ];

    public function getvalueByKey($provider, $key = '', $login = true)
    {
        $social = '';
        if ($key == 'redirect' && $login == true) {
            $social = url('social/login/'.$provider);
        }
        if ($key !== '' && $key !== 'redirect') {
            $social = $this->where('provider', $provider)->where('key', $key)->first();
        } elseif ($key !== 'redirect') {
            $social = $this->where('provider', $provider)->pluck('value', 'key')->toArray();
        }
        if (is_object($social)) {
            $social = $social->value;
        }

        return $social;
    }

    public function checkActive($provider)
    {
        $check = '';
        $social = $this->where('provider', $provider)->where('key', 'status')->first();
        if ($social) {
            $value = $social->value;
            if ($value === '1') {
                $check = true;
            }
        }

        return $check;
    }

    public function checkInactive($provider)
    {
        $check = '';
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
