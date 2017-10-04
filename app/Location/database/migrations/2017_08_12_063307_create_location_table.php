<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('location', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('location_category_id')->unsigned()->nullable();
            // $table->foreign('location_category_id')->references('id')->on('sd_location_categories');
            $table->string('title');
            // $table->integer('organization')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            // $table->integer('all_department_access');
            // $table->string('departments');
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
        Schema::drop('location');
    }
}
