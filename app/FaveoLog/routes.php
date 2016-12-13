<?php

Breadcrumbs::register('logs', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('System Logs', route('logs'));
});
Route::group(['middleware' => ['web', 'auth', 'roles']], function() {
    Route::get('logs', ['as' => 'logs', 'uses' => 'App\FaveoLog\controllers\LogViewerController@index']);
});

