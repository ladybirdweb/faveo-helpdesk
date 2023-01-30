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
        Schema::create('settings_email', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template');
            $table->string('sys_email')->nullable();
            $table->string('alert_email')->nullable();
            $table->string('admin_email')->nullable();
            $table->string('mta')->nullable();
            $table->boolean('email_fetching')->default(0);
            $table->boolean('notification_cron')->default(0);
            $table->boolean('strip')->default(0);
            $table->boolean('separator')->default(0);
            $table->boolean('all_emails')->default(0);
            $table->boolean('email_collaborator')->default(0);
            $table->boolean('attachment')->default(0);
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
};
