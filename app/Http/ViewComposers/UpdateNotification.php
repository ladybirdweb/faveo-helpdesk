<?php

namespace App\Http\ViewComposers;

use App\Model\Update\BarNotification;
use Illuminate\View\View;

class UpdateNotification
{
    public function __construct()
    {
    }

    public function compose(View $view)
    {
        $notification = new BarNotification();
        $notice = $notification->where('value', '!=', '')->select('value')->get();
        $view->with(['notification' => $notice]);
    }
}
