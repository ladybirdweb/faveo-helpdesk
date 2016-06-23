<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('department_id')->unsigned()->nullable();
            $table->foreign('department_id')->references('id')->on('department');
            $table->integer('asset_type_id')->unsigned()->nullable();
            $table->foreign('asset_type_id')->references('id')->on('sd_asset_types');
            $table->integer('impact_type_id')->unsigned()->nullable();
            $table->foreign('impact_type_id')->references('id')->on('sd_impact_types');
            $table->integer('managed_by')->unsigned()->nullable();
            $table->foreign('managed_by')->references('id')->on('users');
            $table->integer('used_by')->unsigned()->nullable();
            $table->foreign('used_by')->references('id')->on('users');
            $table->integer('attachment')->unsigned()->nullable();
            $table->foreign('attachment')->references('id')->on('sd_attachments');
            $table->integer('location_id')->unsigned()->nullable();
            $table->foreign('location_id')->references('id')->on('sd_locations');
            $table->timestamp('assigned_on');
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
        Schema::drop('sd_assets');
    }
}
