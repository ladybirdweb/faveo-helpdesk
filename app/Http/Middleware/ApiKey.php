<?php

namespace App\Http\Middleware;

use App\Model\helpdesk\Settings\System;
use Closure;

class ApiKey
{
    public $setting;

    public function __construct()
    {
        $setting = new System();
        $this->setting = $setting;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $set = $this->setting->where('id', '1')->first();
        if ($set->api_key_mandatory == 1) {
            if ($set->api_enable == 1) {
                $key = $set->api_key;
                $check = $this->test($key, $request->input('api_key'));
                if ($check == '1') {
                    return $next($request);
                }
                if ($check == '0') {
                    $result = 'wrong api key';

                    return response()->json(compact('result'));
                }
            } else {
                $result = 'please enable api';

                return response()->json(compact('result'));
            }
        } else {
            return $next($request);
        }
    }

    public function test($v1, $v2)
    {
        if ($v1 == $v2) {
            return '1';
        } else {
            return '0';
        }
    }
}
