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
        Schema::create('department', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->integer('sla')->unsigned()->nullable()->index('sla');
            $table->integer('manager')->unsigned()->nullable()->index('manager_2');
            $table->string('ticket_assignment')->nullable();
            $table->string('outgoing_email')->nullable();
            $table->string('template_set')->nullable();
            $table->string('auto_ticket_response')->nullable();
            $table->string('auto_message_response')->nullable();
            $table->string('auto_response_email')->nullable();
            $table->string('recipient')->nullable();
            $table->string('group_access')->nullable();
            $table->string('department_sign')->nullable();
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
        Schema::drop('department');
    }
};
