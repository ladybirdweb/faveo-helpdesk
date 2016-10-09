<?php

namespace App\Plugins\Zapier\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Plugins\Zapier\Model\Zapier;
use Artisan;
use Illuminate\Http\Request;
use Schema;

class SettingsController extends Controller
{
    public function settings()
    {
        $zapier = new Zapier();
        $apps = include base_path('app/Plugins/Zapier/Zapier.php');

        return view('zapier::core.settings', compact('apps', 'zapier'));
    }

    public function activateIntegration($app, Request $request)
    {
        //dd($request->all());
        $zapier = new Zapier();
        $requests = $request->except('_token');
        if (count($requests) > 0) {
            foreach ($requests as $key => $value) {
                $this->deleteZapier($app, $key);
                $zapier->create([
                    'app'   => $app,
                    'key'   => $key,
                    'value' => $value,
                ]);
            }
        }
    }

    public function deleteZapier($app, $key)
    {
        $zapiers = new Zapier();
        $zapier = $zapiers->where('app', $app)->where('key', $key)->first();
        if ($zapier) {
            $zapier->delete();
        }
    }

    public function activate()
    {
        if (env('DB_INSTALL') == 1 && !Schema::hasTable('zapier')) {
            $path = 'app'.DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'Zapier'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';
            Artisan::call('migrate', [
                '--path'  => $path,
                '--force' => true,
            ]);
        }
        $this->activateDependency();
    }

    public function activateDependency()
    {
        if (env('DB_INSTALL') == 1 && !Schema::hasTable('social_channel')) {
            $path = 'app'.DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'Zapier'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.'depend';
            Artisan::call('migrate', [
                '--path'  => $path,
                '--force' => true,
            ]);
        }
    }
}
