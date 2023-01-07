<?php

namespace App\Http\Controllers\Admin\helpdesk;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class UrlSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles']);
    }

    public function settings(Request $request)
    {
        $url = $request->url();
        $www = $this->checkWWW($url);
        $https = $this->checkHTTP($url);
        //dd($www, $https);
        try {
            return view('themes.default1.admin.helpdesk.settings.url.settings', compact('www', 'https'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function postSettings(Request $request)
    {
        try {
            $www = $request->input('www');
            $ssl = $request->input('ssl');
            $string_www = $this->www($www);
            $sting_ssl = $this->ssl($ssl);
            $string = $string_www.$sting_ssl;
            $this->writeHtaccess($string);

            return redirect()->back()->with('success', 'updated');
        } catch (Exception $ex) {
            dd($ex);

            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function www($www)
    {
        switch ($www) {
            case 'yes':
                return $this->changeWww();
            case 'no':
                return $this->changeNonwww();
        }
    }

    public function changeWww()
    {
        $string = "RewriteCond %{HTTP_HOST} !^www\.
RewriteRule ^(.*)$ http://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\n";

        return $string;
    }

    public function changeNonwww()
    {
        $string = "RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
RewriteRule ^(.*)$ http://%1/$1 [R=301,L]\n";

        return $string;
    }

    public function ssl($ssl)
    {
        switch ($ssl) {
            case 'yes':
                return $this->changeHttps();
            case 'no':
                return $this->changeHttp();
        }
    }

    public function changeHttps()
    {
        $string = "RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\n";

        return $string;
    }

    public function changeHttp()
    {
        //$string = "RewriteCond %{HTTPS} off
        //RewriteRule ^(.*)$ http://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\n";
        $string = '';

        return $string;
    }

    public function writeHtaccess($string)
    {
        //dd(public_path('.htaccess'),base_path('.htaccess'));
        $file = public_path('.htaccess');
        if (!\File::exists($file)) {
            $file = base_path('/../.htaccess');
        }
        $this->deleteCustom();
        $content = file_get_contents($file);
        file_put_contents($file, $content."#custom\n".$string);
        $new_content = file_get_contents($file);
    }

    public function deleteCustom()
    {
        $file = public_path('.htaccess');
        if (!\File::exists($file)) {
            $file = base_path('/../.htaccess');
        }
        $content = file_get_contents($file);
        $custom_pos = strpos($content, '#custom');
        if ($custom_pos) {
            $content = substr_replace($content, '', $custom_pos);
        }
        file_put_contents($file, $content);
    }

    public function checkWwwInUrl($url)
    {
        $check = false;
        if (strpos($url, 'www') !== false) {
            $check = true;
        }

        return $check;
    }

    public function checkHttpsInUrl($url)
    {
        $check = false;
        if (strpos($url, 'https') !== false) {
            $check = true;
        }

        return $check;
    }

    public function checkWWW($url)
    {
        $check = $this->checkWwwInUrl($url);
        $array['www'] = true;
        $array['nonwww'] = false;
        if ($check == false) {
            $array['www'] = false;
            $array['nonwww'] = true;
        }

        return $array;
    }

    public function checkHTTP($url)
    {
        $check = $this->checkHttpsInUrl($url);
        $array['https'] = true;
        $array['http'] = false;
        if ($check == false) {
            $array['https'] = false;
            $array['http'] = true;
        }

        return $array;
    }
}
