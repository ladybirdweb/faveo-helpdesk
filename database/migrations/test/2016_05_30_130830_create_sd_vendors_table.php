<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSdVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('primary_contact');
            $table->string('email');
            $table->string('description');
            $table->string('address');
            $table->boolean('all_department');
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
        Schema::drop('sd_vendors');
    }
}
