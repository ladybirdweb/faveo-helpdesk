<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sla_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('grace_period');
            $table->string('admin_note');
            $table->boolean('status');
            $table->boolean('transient');
            $table->boolean('ticket_overdue');
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
        Schema::drop('sla_plan');
    }
};
