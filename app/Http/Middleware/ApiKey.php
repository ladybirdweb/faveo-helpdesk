<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\helpdesk\Settings\System;

class ApiKey {

    public $setting;

    public function __construct() {
        $setting = new System();
        $this->setting = $setting;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $set = $this->setting->where('id', '1')->first();
        if ($set->api_enable == 1) {
            $key = $set->api_key;
            if ($key == $request->input('api_key')) {
                return $next($request);
            } else {
                $result = 'wrong api key';
                return response()->json(compact('result'));
            }
        } else {
            $result = 'please enable api';
            return response()->json(compact('result'));
        }
    }

}
