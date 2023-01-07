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
        Schema::create('kb_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->unsigned()->index('comment_article_id_foreign');
            $table->string('name');
            $table->string('email');
            $table->string('website');
            $table->string('comment');
            $table->boolean('status');
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
        Schema::drop('kb_comment');
    }
};
