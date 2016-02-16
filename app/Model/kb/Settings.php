<?php

namespace App\Model\kb;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model {

    /**
     * @param $table, $fillable
     * @package default
     */
    protected $table = 'kb_settings';
    protected $fillable = ['language', 'dateformat', 'company_name', 'website', 'phone', 'address', 'logo', 'timezone',
        'background', 'version', 'pagination', 'port', 'host', 'encryption', 'email', 'password'];

}
