<?php

namespace App\Http\Controllers\Admin\helpdesk;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Exception;

class UrlSettingController extends Controller
{
    public function settings(){
        try{
            
        } catch (Exception $ex) {
            return redirect()->back()->with('fails',$ex->getMessage());
        }
    }
}
