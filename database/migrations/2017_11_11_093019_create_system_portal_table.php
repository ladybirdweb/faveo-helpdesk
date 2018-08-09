<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystemPortalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_portal', function (Blueprint $table) {
            $table->increments('id');

            $table->string('admin_header_color');
            $table->string('agent_header_color');
            $table->string('client_header_color');
            $table->string('client_button_color');
            $table->string('client_button_border_color');
            $table->string('client_input_fild_color');
            $table->string('logo');

            $table->string('icon');

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
        Schema::drop('system_portal');
    }
}
