<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Support\Facades\Route;

Breadcrumbs::register('logs', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('System Logs', route('logs'));
});
Route::middleware('web', 'auth', 'roles')->group(function () {
    Route::get('logs', [\App\FaveoLog\controllers\LogViewerController::class, 'index'])->name('logs');
});
