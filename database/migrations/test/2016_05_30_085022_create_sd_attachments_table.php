<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSdAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('saved')->unsigned();
            $table->string('owner');
            $table->foreign('saved')->references('id')->on('sd_attachment_types');
            $table->text('value');
            $table->string('type');
            $table->string('size');
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
        Schema::drop('sd_asset_attachments');
    }
}
