<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSdContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sd_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->string('cost');
            $table->integer('contract_type_id')->unsigned();
            $table->foreign('contract_type_id')->references('id')->on('sd_contract_types');
            $table->integer('approver_id')->unsigned();
            $table->foreign('approver_id')->references('id')->on('users');
            $table->integer('vendor_id')->unsigned();
            $table->foreign('vendor_id')->references('id')->on('sd_vendors');
            $table->integer('license_type_id')->unsigned();
            $table->foreign('license_type_id')->references('id')->on('sd_license_types');
            $table->integer('licensce_count');
            $table->integer('attachment')->unsigned();
            $table->foreign('attachment')->references('id')->on('sd_attachments');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('sd_products');
            $table->boolean('notify_expiry');
            $table->timestamp('contract_start_date');
            $table->timestamp('contract_end_date');
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
        Schema::drop('sd_contracts');
    }
}
