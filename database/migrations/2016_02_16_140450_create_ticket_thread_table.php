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
        Schema::create('ticket_thread', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id')->unsigned()->nullable()->index('ticket_id_2');
            $table->integer('user_id')->unsigned()->nullable()->index('user_id');
            $table->string('poster');
            $table->integer('source')->unsigned()->nullable()->index('source');
            $table->integer('reply_rating');
            $table->integer('rating_count');
            $table->boolean('is_internal');
            $table->string('title');
            $table->text('body', 65535);
            $table->string('format');
            $table->string('ip_address');
            $table->timestamps();
        });
        \DB::statement('ALTER TABLE `ticket_thread` MODIFY `body` LONGBLOB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ticket_thread');
    }
};
