<?php

Route::group(['middleware' => ['web', 'auth', 'roles'], 'prefix' => 'telephone'], function () {
    Route::get('settings', ['as' => 'telephone.settings', 'uses' => 'App\Plugins\Telephony\Controllers\Core\SettingsController@settings']);
    Route::get('seed', ['as' => 'telephone.seed', 'uses' => 'App\Plugins\Telephony\Controllers\Core\SettingsController@seed']);
    Route::get('{short}/settings', ['as' => 'telephone.provider.setting', 'uses' => 'App\Plugins\Telephony\Controllers\Core\SettingsController@settingsProvider']);
    Route::post('{short}', ['as' => 'telephone.provider', 'uses' => 'App\Plugins\Telephony\Controllers\Core\SettingsController@postSettingsProvider']);
});

/*
 * Exotel
 */
Route::get('telephone/exotel/pass', ['as' => 'telephone.exotel.pass', 'uses' => 'App\Plugins\Telephony\Controllers\Exotel\ExotelController@passThrough']);
Route::get('telephone/exotel/values', ['as' => 'telephone.exotel.values', 'uses' => 'App\Plugins\Telephony\Controllers\Exotel\ExotelController@getValues']);
