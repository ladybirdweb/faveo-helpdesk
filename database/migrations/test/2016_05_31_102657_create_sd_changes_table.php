<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSdChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_changes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('subject');
            $table->string('reason');
            $table->string('impact');
            $table->string('rollout_plan');
            $table->string('backout_plan');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('sd_change_status');
            $table->integer('priority_id')->unsigned();
            $table->foreign('priority_id')->references('id')->on('sd_change_priorities');
            $table->integer('change_type_id')->unsigned();
            $table->foreign('change_type_id')->references('id')->on('sd_change_types');
            $table->integer('impact_id')->unsigned();
            $table->foreign('impact_id')->references('id')->on('sd_impact_types');
            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('sd_location_categories');
            $table->integer('approval_id')->unsigned();
            $table->foreign('approval_id')->references('id')->on('users');
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
        Schema::drop('sd_changes');
    }
}
