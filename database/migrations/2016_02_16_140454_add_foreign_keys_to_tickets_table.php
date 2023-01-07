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
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign('user_id', 'tickets_ibfk_1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('dept_id', 'tickets_ibfk_2')->references('id')->on('department')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('team_id', 'tickets_ibfk_3')->references('id')->on('teams')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('priority_id', 'tickets_ibfk_4')->references('priority_id')->on('ticket_priority')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('sla', 'tickets_ibfk_5')->references('id')->on('sla_plan')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('help_topic_id', 'tickets_ibfk_6')->references('id')->on('help_topic')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('status', 'tickets_ibfk_7')->references('id')->on('ticket_status')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('source', 'tickets_ibfk_8')->references('id')->on('ticket_source')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('assigned_to', 'tickets_ibfk_9')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_ibfk_1');
            $table->dropForeign('tickets_ibfk_2');
            $table->dropForeign('tickets_ibfk_3');
            $table->dropForeign('tickets_ibfk_4');
            $table->dropForeign('tickets_ibfk_5');
            $table->dropForeign('tickets_ibfk_6');
            $table->dropForeign('tickets_ibfk_7');
            $table->dropForeign('tickets_ibfk_8');
            $table->dropForeign('tickets_ibfk_9');
        });
    }
};
