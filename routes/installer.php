<?php

Route::get('serial', [
    'as' => 'serialkey',
    'uses' => 'Installer\helpdesk\InstallController@serialkey',
]);
Route::post('/post-serial', [
    'as' => 'post.serialkey',
    'uses' => 'Installer\helpdesk\InstallController@postSerialKeyToFaveo',
]);
Route::post('/post-bill', [
    'as' => 'return.bill',
    'uses' => 'Installer\helpdesk\InstallController@returnFormBilling',
]);

Route::get('/JavaScript-disabled', [
    'as' => 'js-disabled',
    'uses' => 'Installer\helpdesk\InstallController@jsDisabled',
]);
Route::get('/step2', [
    'as' => 'licence',
    'uses' => 'Installer\helpdesk\InstallController@licence',
]);
Route::post('/step1post', [
    'as' => 'postlicence',
    'uses' => 'Installer\helpdesk\InstallController@licencecheck',
]);
Route::get('/step1', [
    'as' => 'prerequisites',
    'uses' => 'Installer\helpdesk\InstallController@prerequisites',
]);
Route::post('/step2post', [
    'as' => 'postprerequisites',
    'uses' => 'Installer\helpdesk\InstallController@prerequisitescheck',
]);
Route::get('/step3', [
    'as' => 'configuration',
    'uses' => 'Installer\helpdesk\InstallController@configuration',
]);
Route::post('/step4post', [
    'as' => 'postconfiguration',
    'uses' => 'Installer\helpdesk\InstallController@configurationcheck',
]);
Route::get('/step4', [
    'as' => 'database',
    'uses' => 'Installer\helpdesk\InstallController@database',
]);
Route::get('/step5', [
    'as' => 'account',
    'uses' => 'Installer\helpdesk\InstallController@account',
]);
Route::post('/step6post', [
    'as' => 'postaccount',
    'uses' => 'Installer\helpdesk\InstallController@accountcheck',
]);
Route::get('/final', [
    'as' => 'final',
    'uses' => 'Installer\helpdesk\InstallController@finalize',
]);
Route::post('/finalpost', [
    'as' => 'postfinal',
    'uses' => 'Installer\helpdesk\InstallController@finalcheck',
]);
Route::post('/postconnection', [
    'as' => 'postconnection',
    'uses' => 'Installer\helpdesk\InstallController@postconnection',
]);
Route::get('/change-file-permission', [
    'as' => 'change-permission',
    'uses' => 'Installer\helpdesk\InstallController@changeFilePermission',
]);

Route::get('create/env', [
    'as' => 'create.env',
    'uses' => 'Installer\helpdesk\InstallController@createEnv',
]);

Route::get('preinstall/check', [
    'as' => 'preinstall.check',
    'uses' => 'Installer\helpdesk\InstallController@checkPreInstall',
]);

Route::get('migrate', [
    'as' => 'migrate',
    'uses' => 'Installer\helpdesk\InstallController@migrate',
]);

Route::get('seed', [
    'as' => 'seed',
    'uses' => 'Installer\helpdesk\InstallController@seed',
]);

Route::get('update/install', [
    'as' => 'update.install',
    'uses' => 'Installer\helpdesk\InstallController@updateInstalEnv',
]);
