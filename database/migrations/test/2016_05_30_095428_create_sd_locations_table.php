<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSdLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_category_id')->unsigned()->nullable();
            $table->foreign('location_category_id')->references('id')->on('sd_location_categories');
            $table->string('title');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->integer('all_department_access');
            $table->string('departments');
            $table->integer('status');
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
        Schema::drop('sd_locations');
    }
}
