<?php

Route::get('serial', 'Installer\helpdesk\InstallController@serialkey')->name('serialkey');
Route::post('/post-serial', 'Installer\helpdesk\InstallController@postSerialKeyToFaveo')->name('post.serialkey');
Route::post('/post-bill', 'Installer\helpdesk\InstallController@returnFormBilling')->name('return.bill');

Route::get('/JavaScript-disabled', 'Installer\helpdesk\InstallController@jsDisabled')->name('js-disabled');
Route::get('/step2', 'Installer\helpdesk\InstallController@licence')->name('licence');
Route::post('/step1post', 'Installer\helpdesk\InstallController@licencecheck')->name('postlicence');
Route::get('/step1', 'Installer\helpdesk\InstallController@prerequisites')->name('prerequisites');
Route::post('/step2post', 'Installer\helpdesk\InstallController@prerequisitescheck')->name('postprerequisites');
Route::get('/step3', 'Installer\helpdesk\InstallController@configuration')->name('configuration');
Route::post('/step4post', 'Installer\helpdesk\InstallController@configurationcheck')->name('postconfiguration');
Route::get('/step4', 'Installer\helpdesk\InstallController@database')->name('database');
Route::get('/step5', 'Installer\helpdesk\InstallController@account')->name('account');
Route::post('/step6post', 'Installer\helpdesk\InstallController@accountcheck')->name('postaccount');
Route::get('/final', 'Installer\helpdesk\InstallController@finalize')->name('final');
Route::post('/finalpost', 'Installer\helpdesk\InstallController@finalcheck')->name('postfinal');
Route::post('/postconnection', 'Installer\helpdesk\InstallController@postconnection')->name('postconnection');
Route::get('/change-file-permission', 'Installer\helpdesk\InstallController@changeFilePermission')->name('change-permission');

Route::get('create/env', 'Installer\helpdesk\InstallController@createEnv')->name('create.env');

Route::get('preinstall/check', 'Installer\helpdesk\InstallController@checkPreInstall')->name('preinstall.check');

Route::get('migrate', 'Installer\helpdesk\InstallController@migrate')->name('migrate');

Route::get('seed', 'Installer\helpdesk\InstallController@seed')->name('seed');

Route::get('update/install', 'Installer\helpdesk\InstallController@updateInstalEnv')->name('update.install');
