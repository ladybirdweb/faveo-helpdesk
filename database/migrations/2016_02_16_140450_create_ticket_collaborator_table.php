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
        Schema::create('ticket_collaborator', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('isactive');
            $table->integer('ticket_id')->unsigned()->nullable()->index('ticket_id');
            $table->integer('user_id')->unsigned()->nullable()->index('user_id');
            $table->string('role');
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
        Schema::drop('ticket_collaborator');
    }
};
