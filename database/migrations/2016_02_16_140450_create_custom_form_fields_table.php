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
        Schema::create('custom_form_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forms_id');
            $table->string('label');
            $table->string('name');
            $table->string('type');
            $table->string('value');
            $table->string('required');
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
        Schema::drop('custom_form_fields');
    }
};
