<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VersionAfter_1_0_7_8_Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $current_version1 = \Config::get('app.version');
        $current_version2 = explode(' ', $current_version1);
        $current_version = $current_version2[1];
        DB::table('settings_system')->insert(['version' => $current_version]);
    }

}
