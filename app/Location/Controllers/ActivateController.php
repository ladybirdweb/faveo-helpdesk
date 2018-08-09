<?php

namespace App\Location\Controllers;

use App\Http\Controllers\Controller;
use Artisan;
use Exception;

/**
 * Location activation controller.
 *
 * @abstract Controller
 *
 * @author Ladybird Web Solution <admin@ladybirdweb.com>
 * @name ActivateController
 */
class ActivateController extends Controller
{
    /**
     * Activating the billing module.
     */
    public function activate()
    {
        try {
            if (!\Schema::hasTable('location')) {
                $this->migrate();
            }
            //$this->seed();
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    /**
     * publishing the module in laravel way.
     */
    public function publish()
    {
        try {
            $publish = 'vendor:publish';
            $provider = 'App\Location\LocationServiceProvider';
            $tag = 'migrations';
            $r = Artisan::call($publish, ['--provider' => $provider, '--tag' => [$tag]]);
            //dd($r);
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    /**
     * Running migration for Location.
     */
    public function migrate()
    {
        try {
            $path = 'app'.DIRECTORY_SEPARATOR.'Location'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';
            Artisan::call('migrate', [
                '--path'  => $path,
                '--force' => true,
            ]);
        } catch (Exception $ex) {
            dd($ex);
        }
    }
}
