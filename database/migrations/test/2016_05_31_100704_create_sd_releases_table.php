<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_releases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('subject');
            $table->timestamp('planned_start_date');
            $table->timestamp('planned_end_date');
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('sd_release_status');
            $table->integer('priority_id')->unsigned()->nullable();
            $table->foreign('priority_id')->references('id')->on('sd_release_priorities');
            $table->integer('release_type_id')->unsigned()->nullable();
            $table->foreign('release_type_id')->references('id')->on('sd_release_types');
            $table->integer('location_id')->unsigned()->nullable();
            $table->foreign('location_id')->references('id')->on('sd_locations');
            $table->string('build_plan');
            $table->string('build_plan_attachment');
            $table->string('test_plan');
            $table->string('test_plan_attachment');
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
        Schema::drop('sd_releases');
    }
}
