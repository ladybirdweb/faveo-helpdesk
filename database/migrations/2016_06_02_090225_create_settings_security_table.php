<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsSecurityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_security', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lockout_message');
            $table->integer('backlist_offender');
            $table->integer('backlist_threshold');
            $table->integer('lockout_period');
            $table->integer('days_to_keep_logs');
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
        Schema::drop('settings_security');
    }
}
