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
        Schema::create('settings_ticket', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num_format');
            $table->string('num_sequence');
            $table->string('priority');
            $table->string('sla');
            $table->string('help_topic');
            $table->string('max_open_ticket');
            $table->string('collision_avoid');
            $table->string('lock_ticket_frequency')->default(0);
            $table->string('captcha');
            $table->boolean('status');
            $table->boolean('claim_response');
            $table->boolean('assigned_ticket');
            $table->boolean('answered_ticket');
            $table->boolean('agent_mask');
            $table->boolean('html');
            $table->boolean('client_update');
            $table->boolean('max_file_size');
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
        Schema::drop('settings_ticket');
    }
};
