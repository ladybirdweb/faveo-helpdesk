<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings_system', function (Blueprint $table) {
            $table->foreign('time_zone', 'settings_system_ibfk_1')->references('id')->on('timezone')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('time_farmat', 'settings_system_ibfk_2')->references('id')->on('time_format')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('date_format', 'settings_system_ibfk_3')->references('id')->on('date_format')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('date_time_format', 'settings_system_ibfk_4')->references('id')->on('date_time_format')->onUpdate('NO ACTION')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings_system', function (Blueprint $table) {
            $table->dropForeign('settings_system_ibfk_1');
            $table->dropForeign('settings_system_ibfk_2');
            $table->dropForeign('settings_system_ibfk_3');
            $table->dropForeign('settings_system_ibfk_4');
        });
    }
};
