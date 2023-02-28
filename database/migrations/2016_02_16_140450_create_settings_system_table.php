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
        Schema::create('settings_system', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status');
            $table->string('url');
            $table->string('name');
            $table->string('department');
            $table->string('page_size');
            $table->string('log_level');
            $table->string('purge_log');
            $table->integer('api_enable')->nullable();
            $table->integer('api_key_mandatory')->nullable();
            $table->string('api_key');
            $table->string('name_format');
            $table->integer('time_farmat')->unsigned()->nullable()->index('time_farmat');
            $table->integer('date_format')->unsigned()->nullable()->index('date_format');
            $table->integer('date_time_format')->unsigned()->nullable()->index('date_time_format');
            $table->string('day_date_time');
            $table->integer('time_zone')->unsigned()->nullable()->index('time_zone');
            $table->string('content');
            $table->string('version');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings_system');
    }
};
