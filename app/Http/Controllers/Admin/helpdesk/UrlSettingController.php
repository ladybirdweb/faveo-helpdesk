<?php

namespace App\Http\Controllers\Admin\helpdesk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class UrlSettingController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function settings() {
        try {
            return view('themes.default1.admin.helpdesk.settings.url.settings');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function postSettings(Request $request) {
        try {
            $www = $request->input('www');
            $ssl = $request->input('ssl');
            $string_www = $this->www($www);
            $sting_ssl = $this->ssl($ssl);
            $string = $string_www.$sting_ssl;
            $this->writeHtaccess($string);
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function www($www) {
        switch ($www) {
            case "yes":
                return $this->changeWww();
            case "no":
                return $this->changeNonwww();
        }
    }

    public function changeWww() {
        $string = "RewriteCond %{HTTP_HOST} !^www\.
RewriteRule ^(.*)$ https://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\n";
        return $string;
    }

    public function changeNonwww() {
        $string = "\nRewriteEngine On
RewriteBase /
RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
RewriteRule ^(.*)$ http://%1/$1 [R=301,L]\n";

        return $string;
    }

    public function ssl($ssl) {
        switch ($ssl) {
            case "yes":
                return $this->changeHttps();
            case "no":
                return $this->changeHttp();
        }
    }

    public function changeHttps() {
        $string = "RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\n";
        return $string;
    }

    public function changeHttp() {
        $string = "RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ http://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\n";
        return $string;
    }

    public function writeHtaccess($string) {
        $file = base_path('.htaccess');
        $this->deleteCustom();
        $content = file_get_contents($file);
        file_put_contents($file, $content . "#custom\n".$string);
        $new_content = file_get_contents($file);
        dd($new_content);
    }
    
    public function deleteCustom(){
        $file = base_path('.htaccess');
        $content = file_get_contents($file);
        $custom_pos = strpos($content, '#custom');
        if($custom_pos){
            $content = substr_replace($content, '',$custom_pos);
        }
        //dd($trim);
        file_put_contents($file,$content);
    }

}
