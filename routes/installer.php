<?php

use App\Http\Controllers\Installer;
use Illuminate\Support\Facades\Route;

Route::get('serial', [Installer\helpdesk\InstallController::class, 'serialkey'])->name('serialkey');
Route::post('/post-serial', [Installer\helpdesk\InstallController::class, 'postSerialKeyToFaveo'])->name('post.serialkey');
Route::post('/post-bill', [Installer\helpdesk\InstallController::class, 'returnFormBilling'])->name('return.bill');

Route::get('/JavaScript-disabled', [Installer\helpdesk\InstallController::class, 'jsDisabled'])->name('js-disabled');
Route::get('/step2', [Installer\helpdesk\InstallController::class, 'licence'])->name('licence');
Route::post('/step1post', [Installer\helpdesk\InstallController::class, 'licencecheck'])->name('postlicence');
Route::get('/step1', [Installer\helpdesk\InstallController::class, 'prerequisites'])->name('prerequisites');
Route::post('/step2post', [Installer\helpdesk\InstallController::class, 'prerequisitescheck'])->name('postprerequisites');
Route::get('/step3', [Installer\helpdesk\InstallController::class, 'configuration'])->name('configuration');
Route::post('/step4post', [Installer\helpdesk\InstallController::class, 'configurationcheck'])->name('postconfiguration');
Route::get('/step4', [Installer\helpdesk\InstallController::class, 'database'])->name('database');
Route::get('/step5', [Installer\helpdesk\InstallController::class, 'account'])->name('account');
Route::post('/step6post', [Installer\helpdesk\InstallController::class, 'accountcheck'])->name('postaccount');
Route::get('/final', [Installer\helpdesk\InstallController::class, 'finalize'])->name('final');
Route::post('/finalpost', [Installer\helpdesk\InstallController::class, 'finalcheck'])->name('postfinal');
Route::post('/postconnection', [Installer\helpdesk\InstallController::class, 'postconnection'])->name('postconnection');
Route::get('/change-file-permission', [Installer\helpdesk\InstallController::class, 'changeFilePermission'])->name('change-permission');

Route::get('create/env', [Installer\helpdesk\InstallController::class, 'createEnv'])->name('create.env');

Route::get('preinstall/check', [Installer\helpdesk\InstallController::class, 'checkPreInstall'])->name('preinstall.check');

Route::get('migrate', [Installer\helpdesk\InstallController::class, 'migrate'])->name('migrate');

Route::get('seed', [Installer\helpdesk\InstallController::class, 'seed'])->name('seed');

Route::get('update/install', [Installer\helpdesk\InstallController::class, 'updateInstalEnv'])->name('update.install');
