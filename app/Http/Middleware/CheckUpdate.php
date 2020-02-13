<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Update\UpgradeController;
use App\Http\Controllers\Utility\LibraryController as Utility;
use App\Model\Update\BarNotification;
use Closure;

class CheckUpdate
{
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
        $check = $this->process();
        //dd($check);
        if ($check == true) {
            //$this->notificationBar();
            $this->checkNewUpdate();
//            if (Utility::getFileVersion() > Utility::getDatabaseVersion()) {
//                return redirect('database-update');
//            }
//            if (Utility::getFileVersion() < Utility::getDatabaseVersion()) {
//                return redirect('file-update');
//            }
        }

        return $next($request);
    }

    public function notificationBar()
    {
        $notify = new BarNotification();
        $path = base_path('UPDATES');
        if (is_dir($path)) {
            $notify->create(['key' => 'update-ready', 'value' => 'New version has downloaded, click <a href='.url('file-update').'>here</a> to update now']);
        }
    }

    public function checkNewUpdate()
    {
        $notify = new BarNotification();
        if (!\Schema::hasTable('bar_notifications')) {
            $url = url('database-upgrade');
            //$string = "Your Database is outdated please upgrade <a href=$url>Now !</a>";
            echo view('themes.default1.update.database', compact('url'));
            exit;
        }
        $not = $notify->get();
        if ($not->count() > 0) {
            $now = \Carbon\Carbon::now();
            $yesterday = \Carbon\Carbon::yesterday();
            $notifications = $notify->whereBetween('created_at', [$yesterday, $now])->pluck('value', 'key');
            $todelete = $notify->where('created_at', '<', $yesterday)->get();
            if ($todelete->count() > 0) {
                foreach ($todelete as $delete) {
                    $delete->delete();
                }
            }
            if (count($notifications) > 0) {
                if (!array_key_exists('new-version', $notifications)) {
                    $check_version = $this->checkNewVersion();
                    if ($check_version == true) {
                        $notify->create(['key' => 'new-version', 'value' => 'new version found please click <a href='.url('file-update').'><b>here to download</b></a>']);
                    }
                } else {
                    $n = $notify->where('key', 'new-version')->first();
                    $last = $n->created_at;
                    $now = \Carbon\Carbon::now();
                    $difference = $now->diffInHours($last);
                    if ($difference >= 24) {
                        $n->delete();
                        $this->checkNewUpdate();
                    }
                }
            }
        } else {
            $check_version = $this->checkNewVersion();

            if ($check_version == true) {
                //dd('if');
                $notify->create(['key' => 'new-version', 'value' => 'new version found please click <a href='.url('file-update').'><b>here to download</b></a>', 'created_at' => \Carbon\Carbon::now()]);
            } else {
                //dd('else');
                $notify->create(['key' => 'new-version', 'value' => '', 'created_at' => \Carbon\Carbon::now()]);
            }
        }
    }

    public function checkNewVersion()
    {
        $controller = new UpgradeController();
        $version_from_billing = $controller->getLatestVersion();
        $app_version = Utility::getFileVersion();
        if ($version_from_billing > $app_version) {
            return true;
        }
    }

    public function process()
    {
        $notify = new BarNotification();
        $not = $notify->get();
        if ($not->count() > 0) {
            $n = $notify->where('key', 'new-version')->first();

            if ($n) {
                $now = \Carbon\Carbon::now();
                $yesterday = \Carbon\Carbon::yesterday();
                $notifications = $notify->where('key', 'new-version')->whereBetween('created_at', [$yesterday, $now])->pluck('value', 'key');
                if ($notifications->count() > 0) {
                    return false;
                }
            }
        }

        return true;
    }
}
