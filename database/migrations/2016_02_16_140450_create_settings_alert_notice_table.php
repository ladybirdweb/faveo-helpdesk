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
        Schema::create('settings_alert_notice', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('ticket_status')->default(0);
            $table->boolean('ticket_admin_email')->default(0);
            $table->boolean('ticket_department_manager')->default(0);
            $table->boolean('ticket_department_member')->default(0);
            $table->boolean('ticket_organization_accmanager')->default(0);
            $table->boolean('message_status')->default(0);
            $table->boolean('message_last_responder')->default(0);
            $table->boolean('message_assigned_agent')->default(0);
            $table->boolean('message_department_manager')->default(0);
            $table->boolean('message_organization_accmanager')->default(0);
            $table->boolean('internal_status')->default(0);
            $table->boolean('internal_last_responder')->default(0);
            $table->boolean('internal_assigned_agent')->default(0);
            $table->boolean('internal_department_manager')->default(0);
            $table->boolean('assignment_status')->default(0);
            $table->boolean('assignment_assigned_agent')->default(0);
            $table->boolean('assignment_team_leader')->default(0);
            $table->boolean('assignment_team_member')->default(0);
            $table->boolean('transfer_status')->default(0);
            $table->boolean('transfer_assigned_agent')->default(0);
            $table->boolean('transfer_department_manager')->default(0);
            $table->boolean('transfer_department_member')->default(0);
            $table->boolean('overdue_status')->default(0);
            $table->boolean('overdue_assigned_agent')->default(0);
            $table->boolean('overdue_department_manager')->default(0);
            $table->boolean('overdue_department_member')->default(0);
            $table->boolean('system_error')->default(0);
            $table->boolean('sql_error')->default(0);
            $table->boolean('excessive_failure')->default(0);
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
        Schema::drop('settings_alert_notice');
    }
};
