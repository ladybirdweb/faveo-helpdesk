<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSettingsSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('settings_system');
        Schema::create('settings_system', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status');
            $table->string('url');
            $table->string('name');
            $table->string('department');
            $table->string('page_size');
            $table->string('log_level');
            $table->string('purge_log');
            $table->integer('api_enable');
            $table->integer('api_key_mandatory');
            $table->string('api_key');
            $table->string('name_format');
            $table->integer('time_farmat')->unsigned()->nullable()->index('time_farmat');
            $table->integer('date_format')->unsigned()->nullable()->index('date_format');
            $table->string('time_zone', 50)->nullable();
            $table->string('date_time_format', 50)->nullable();
            $table->string('day_date_time');
            $table->string('content');
            $table->string('version');
            $table->timestamps();
        });
        
        App\Model\helpdesk\Settings\System::create(array('id' => '1', 'status' => '1', 'department' => '1', 'date_time_format' => 'Y-d-m H:m:i', 'time_zone' => 'UTC'));
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings_system', function (Blueprint $table) {
            //
        });
    }
}
