<?php

namespace App\FaveoStorage\Controllers;

use App\Http\Controllers\Controller;
use App\Model\helpdesk\Settings\CommonSettings;
use Artisan;
use Exception;
use Illuminate\Http\Request;
use Lang;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'roles']);
    }

    public function settingsIcon()
    {
        return ' <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="'.url('storage').'">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-save fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >'.Lang::get('storage::lang.storage').'</p>
                    </div>
                </div>';
    }

    public function settings()
    {
        try {
            $settings = new CommonSettings();
            $default = $settings->getOptionValue('storage', 'default', true);
            $private_folder = $settings->getOptionValue('storage', 'private-root', true);
            $pubic_folder = $settings->getOptionValue('storage', 'public-root', true);
            $root = storage_path('app');
            if (!$default) {
                $default = 'local';
            }
            if (!$private_folder) {
                $private_folder = $root.'/private';
            }
            if (!$pubic_folder) {
                $pubic_folder = public_path();
            }

            return view('storage::settings', compact('default', 'private_folder', 'pubic_folder'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function postSettings(Request $request)
    {
        try {
            if ($request->filled('private-root') && !is_dir($request->input('private-root'))) {
                $dir = $request->input('private-root');

                throw new \Exception("'$dir'".' is not a valid directory');
            }
            if ($request->filled('private-root') && !is_writable($request->input('private-root'))) {
                $dir = $request->input('private-root');

                throw new \Exception("'$dir'"." hasn't write permission");
            }
            $requests = $request->except('_token');
            $this->delete();
            if (count($requests) > 0) {
                foreach ($requests as $key => $value) {
                    if ($value) {
                        $this->save($key, $value);
                    }
                }
            }

            return redirect()->back()->with('success', 'Updated');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function delete()
    {
        $settings = CommonSettings::where('option_name', 'storage')->get();
        if ($settings->count() > 0) {
            foreach ($settings as $setting) {
                $setting->delete();
            }
        }
    }

    public function save($key, $value)
    {
        CommonSettings::create([
            'option_name'    => 'storage',
            'optional_field' => $key,
            'option_value'   => $value,
        ]);
    }

    public function directories($root = '')
    {
        if ($root == '') {
            $root = base_path();
        }

        $iter = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
        );

        $paths = [$root];
        foreach ($iter as $path => $dir) {
            if ($dir->isDir()) {
                $paths[$path] = $path;
            }
        }

        return $paths;
    }

    public function attachment()
    {
        $storage = new StorageController();
        $storage->upload();
    }

    public function activate()
    {
        if (!\Schema::hasColumn('ticket_attachment', 'driver')) {
            $path = 'app'.DIRECTORY_SEPARATOR.'FaveoStorage'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';
            Artisan::call('migrate', [
                '--path'  => $path,
                '--force' => true,
            ]);
        }
    }
}
