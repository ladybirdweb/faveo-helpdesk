<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSocialChanelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_channel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('channel'); //ex:twitter
            $table->string('via'); //ex:message
            $table->string('message_id');
            $table->string('con_id')->nullable();
            $table->string('user_id'); //from social media
            $table->string('thread_id');
            $table->string('username'); //from social media
            $table->string('posted_at'); //from social media
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
        //
    }
}
