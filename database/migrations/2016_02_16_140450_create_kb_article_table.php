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
        Schema::create('kb_article', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->string('slug');
            $table->text('description', 65535);
            $table->boolean('status');
            $table->boolean('type');
            $table->dateTime('publish_time')->nullable();
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
        Schema::drop('kb_article');
    }
};
