<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_threads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id');
            $table->integer('thread_id');
            $table->string('message_id');
            $table->integer('uid');
            $table->string('reference_id');
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
        Schema::dropIfExists('email_threads');
    }
}
