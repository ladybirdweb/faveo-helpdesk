<?php

use App\Model\helpdesk\Settings\System;
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
})->purpose('Display an inspiring quote');

Artisan::command('mac-update', function () {
    $emails = new App\Model\helpdesk\Email\Emails();
    $emails->update(['password' => encrypt('')]);
})->purpose('Updating encrypted value to null');

/*
 * Command for pre install check
 */
Artisan::command('preinsatall:check', function () {
    try {
        $check_for_pre_installation = System::select('id')->first();
        if ($check_for_pre_installation) {
            throw new \Exception('The data in database already exist. Please provide fresh database', 100);
        }
    } catch (\Exception $ex) {
        if ($ex->getCode() == 100) {
            $this->call('droptables');
        }
        //throw new \Exception($ex->getMessage());
    }
    $this->info('Preinstall has checked successfully');
})->purpose('check for the pre installation');

/*
 * Migration for installation
 */
Artisan::command('install:migrate', function () {
    try {
        $tableNames = \Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        if (count($tableNames) == 0) {
            $this->call('migrate', ['--force' => true]);
        }
    } catch (Exception $ex) {
        throw new \Exception($ex->getMessage());
    }
    $this->info('Migrated successfully');
})->purpose('migration for install');

/*
 * Seeding for installation
 */
Artisan::command('install:seed', function () {
    \Schema::disableForeignKeyConstraints();
    $tableNames = \Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
    foreach ($tableNames as $name) {
        if ($name == 'migrations') {
            continue;
        }
        \DB::table($name)->truncate();
    }
    (new \App\Http\Controllers\Update\SyncFaveoToLatestVersion())->sync();
    $this->info('seeded successfully');
})->purpose('Seeding for install');
