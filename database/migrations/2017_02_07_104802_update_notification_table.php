<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('log_notification');
        Schema::dropIfExists('notification_types');
        Schema::dropIfExists('user_notification');
        Schema::dropIfExists('notifications');
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table');
            $table->string('modelid');
            $table->string('type');
            $table->string('by');
            $table->string('to');
            $table->string('payload');
            $table->timestamps();
        });
    }
    
    //user_notification
    //

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            //
        });
    }
}
