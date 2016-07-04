<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VersionAfter1078Table extends Migration
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
        $settings_system = DB::table('settings_system')->where('id', '=', '1')->first();
        if($settings_system != null) {
            DB::table('settings_system')->insert(['version' => $current_version]);
        }
    }

}
