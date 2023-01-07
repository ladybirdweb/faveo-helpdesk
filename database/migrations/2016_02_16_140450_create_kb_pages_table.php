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
        Schema::create('kb_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('status');
            $table->boolean('visibility');
            $table->string('slug');
            $table->text('description', 65535);
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
        Schema::drop('kb_pages');
    }
};
