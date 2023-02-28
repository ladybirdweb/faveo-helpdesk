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
        Schema::create('ticket_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('state');
            $table->integer('mode');
            $table->string('message');
            $table->integer('flags');
            $table->integer('sort');
            $table->integer('email_user')->nullable();
            $table->string('icon_class')->nullable();
            $table->string('properties');
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
        Schema::drop('ticket_status');
    }
};
