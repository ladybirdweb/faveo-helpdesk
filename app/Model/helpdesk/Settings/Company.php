<?php

namespace App\Model\helpdesk\Settings;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
class Company extends BaseModel
{
    protected $table = 'settings_company';
    protected $fillable = [
        'company_name', 'website', 'phone', 'address', 'landing_page', 'offline_page',
        'thank_page', 'logo', 'use_logo',
    ];
}
