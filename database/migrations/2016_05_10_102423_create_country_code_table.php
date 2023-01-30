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
        Schema::create('country_code', function (Blueprint $table) {
            $table->increments('id');
            $table->char('iso', 2)->nullable();
            $table->string('name', 100);
            $table->string('nicename', 100);
            $table->char('iso3', 3)->nullable();
            $table->string('numcode');
            $table->integer('phonecode');
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
        Schema::drop('country_code');
    }
};
