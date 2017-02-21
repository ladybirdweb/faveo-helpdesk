<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class UserLanguage
{
    public function __construct()
    {
    }

    public function compose(View $view)
    {
    	$path = base_path().DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'lang';
    	$langs = scandir($path);
    	$langs = array_diff($langs, ['.', '..']);
    	$languages = [];
    	foreach ($langs as $lang) {
    		$languages[$lang] = \Config::get('languages.'.$lang);
    	}
        $view->with([
        	'langs' => $languages,
        ]);
    }
}
