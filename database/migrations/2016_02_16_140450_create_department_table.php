<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartmentTable extends Migration
{
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
            $table->string('ticket_assignment');
            $table->string('outgoing_email');
            $table->string('template_set');
            $table->string('auto_ticket_response');
            $table->string('auto_message_response');
            $table->string('auto_response_email');
            $table->string('recipient');
            $table->string('group_access');
            $table->string('department_sign');
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
}
