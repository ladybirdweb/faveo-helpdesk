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
        Schema::create('ticket_form_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id')->unsigned()->nullable()->index('ticket_id');
            $table->text('title', 65535);
            $table->text('content', 65535);
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
        Schema::drop('ticket_form_data');
    }
};
