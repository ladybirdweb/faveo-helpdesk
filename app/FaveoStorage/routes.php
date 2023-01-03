<?php

\Event::listen('settings.system', function () {
    $controller = new \App\FaveoStorage\Controllers\SettingsController();
    echo $controller->settingsIcon();
});

Route::group(['middleware' => ['web']], function () {
    Route::get('storage', ['as' => 'storage', 'uses' => 'App\FaveoStorage\Controllers\SettingsController@settings']);
    Route::post('storage', ['as' => 'post.storage', 'uses' => 'App\FaveoStorage\Controllers\SettingsController@postSettings']);
    Route::get('attachment', ['as' => 'attach', 'uses' => 'App\FaveoStorage\Controllers\SettingsController@attachment']);
});
