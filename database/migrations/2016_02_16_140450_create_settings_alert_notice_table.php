<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsAlertNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_alert_notice', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('ticket_status');
            $table->boolean('ticket_admin_email');
            $table->boolean('ticket_department_manager');
            $table->boolean('ticket_department_member');
            $table->boolean('ticket_organization_accmanager');
            $table->boolean('message_status');
            $table->boolean('message_last_responder');
            $table->boolean('message_assigned_agent');
            $table->boolean('message_department_manager');
            $table->boolean('message_organization_accmanager');
            $table->boolean('internal_status');
            $table->boolean('internal_last_responder');
            $table->boolean('internal_assigned_agent');
            $table->boolean('internal_department_manager');
            $table->boolean('assignment_status');
            $table->boolean('assignment_assigned_agent');
            $table->boolean('assignment_team_leader');
            $table->boolean('assignment_team_member');
            $table->boolean('transfer_status');
            $table->boolean('transfer_assigned_agent');
            $table->boolean('transfer_department_manager');
            $table->boolean('transfer_department_member');
            $table->boolean('overdue_status');
            $table->boolean('overdue_assigned_agent');
            $table->boolean('overdue_department_manager');
            $table->boolean('overdue_department_member');
            $table->boolean('system_error');
            $table->boolean('sql_error');
            $table->boolean('excessive_failure');
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
}
