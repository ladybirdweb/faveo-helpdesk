<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequiredsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requireds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('form')->nullable(); //ticket,requester or organisation
            $table->string('field')->nullable();
            $table->string('agent')->nullable(); //agent required
            $table->string('client')->nullable(); //client required
            $table->integer('parent')->nullable(); //inheriting raw id
            $table->string('option')->nullable(); //for values for select,checkboz etc
            $table->string('label')->nullable(); //agent label for the field
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
        Schema::dropIfExists('requireds');
    }
}
