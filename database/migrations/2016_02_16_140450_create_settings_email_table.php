<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_email', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template');
            $table->string('sys_email')->nullable();
            $table->string('alert_email');
            $table->string('admin_email');
            $table->string('mta');
            $table->boolean('email_fetching');
            $table->boolean('notification_cron');
            $table->boolean('strip');
            $table->boolean('separator');
            $table->boolean('all_emails');
            $table->boolean('email_collaborator');
            $table->boolean('attachment');
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
        Schema::drop('settings_email');
    }
}
