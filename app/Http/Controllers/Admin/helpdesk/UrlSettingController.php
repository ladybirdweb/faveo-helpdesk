<?php

namespace App\Http\Controllers\Admin\helpdesk;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class UrlSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function settings(Request $request)
    {
        $url = $request->root();
        $schema = new \App\Model\helpdesk\Settings\CommonSettings();
        $row = $schema->getOptionValue('url', 'app_url');
        if ($row) {
            $url = $row->option_value;
        }
        try {
            return view('themes.default1.admin.helpdesk.settings.url.settings', compact('url'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function postSettings(Request $request)
    {
        try {
            $url = $request->input('url');
            $schema = new \App\Model\helpdesk\Settings\CommonSettings();
            $row = $schema->getOptionValue('url', 'app_url');
            if ($row) {
                $row->delete();
            }
            \App\Model\helpdesk\Settings\CommonSettings::create([
                'option_name'    => 'url',
                'optional_field' => 'app_url',
                'option_value'   => $url,
            ]);

            return redirect()->back()->with('success', 'updated');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
