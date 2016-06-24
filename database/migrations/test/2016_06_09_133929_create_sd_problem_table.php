<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSdProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_problem', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from');
            $table->string('subject');
            $table->string('department');
            $table->string('description');
            $table->integer('status_type_id')->unsigned();
            $table->integer('priority_id')->unsigned();
            $table->integer('impact_id')->unsigned();
            $table->foreign('impact_id')->references('id')->on('sd_impact_types');
            $table->integer('location_type_id')->unsigned();
            $table->foreign('location_type_id')->references('id')->on('sd_locations');
            $table->integer('group_id')->unsigned();
            $table->integer('agent_id')->unsigned();
            $table->integer('assigned_id')->unsigned();
            $table->integer('attachment')->unsigned();
            $table->foreign('attachment')->references('id')->on('sd_attachments');

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
        Schema::drop('sd_problem');
//
    }
}
