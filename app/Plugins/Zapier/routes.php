<?php
/**
 * Auth route.
 */
Route::group(['middleware' => ['web', 'auth', 'roles'], 'prefix' => 'zapier'], function () {
    Route::get('/settings', ['as' => 'zapier.settings', 'uses' => 'App\Plugins\Zapier\Controllers\Core\SettingsController@settings']);
    Route::post('/activate/{app}', ['as' => 'zapier.settings.post', 'uses' => 'App\Plugins\Zapier\Controllers\Core\SettingsController@activateIntegration']);
});

/*
 * Non auth routes
 */
Route::group(['middleware' => ['web'], 'prefix' => 'zapier'], function () {
    Route::get('/', ['as' => 'zapier.post', 'uses' => 'App\Plugins\Zapier\Controllers\Core\ZapierController@zapier']);
});
