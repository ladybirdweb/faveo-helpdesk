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
        Schema::create('ticket_priority', function (Blueprint $table) {
            $table->increments('priority_id');
            $table->string('priority');
            $table->string('status');
            $table->string('priority_desc');
            $table->string('priority_color');
            $table->boolean('priority_urgency');
            $table->boolean('ispublic');
            $table->string('is_default')->nullable();
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
        Schema::drop('ticket_priority');
    }
};
