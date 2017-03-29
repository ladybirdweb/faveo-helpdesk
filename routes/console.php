<?php
use Illuminate\Foundation\Inspiring;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('mac-update', function () {
    $emails = new App\Model\helpdesk\Email\Emails();
    $emails->update(['password'=>encrypt('')]);
})->describe('Updating encrypted value to null');

Artisan::command('sla-escalate', function () {
    $noti = new \App\Http\Controllers\Agent\helpdesk\Notifications\NotificationController();
    $noti->notificationSla();
})->describe('to send notification for sla due');