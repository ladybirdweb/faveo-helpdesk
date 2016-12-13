<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Model\Update\BarNotification;

class UpdateNotification {

    public function __construct() {
        
    }

    public function compose(View $view) {

        $notification = new BarNotification();
        $notice = $notification->where('value', '!=', '')->select('value')->get();
        $view->with(['notification' => $notice]);
    }

}
