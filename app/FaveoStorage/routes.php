<?php

\Event::listen('settings.system', function () {
    $controller = new \App\FaveoStorage\Controllers\SettingsController();
    echo $controller->settingsIcon();
});

Route::middleware('web')->group(function () {
    Route::get('storage', 'App\FaveoStorage\Controllers\SettingsController@settings')->name('storage');
    Route::post('storage', 'App\FaveoStorage\Controllers\SettingsController@postSettings')->name('post.storage');
    Route::get('attachment', 'App\FaveoStorage\Controllers\SettingsController@attachment')->name('attach');
});
