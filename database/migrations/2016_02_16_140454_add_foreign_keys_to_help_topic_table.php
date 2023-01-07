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
        Schema::table('help_topic', function (Blueprint $table) {
            $table->foreign('custom_form', 'help_topic_ibfk_1')->references('id')->on('custom_forms')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('department', 'help_topic_ibfk_2')->references('id')->on('department')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('ticket_status', 'help_topic_ibfk_3')->references('id')->on('ticket_status')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('priority', 'help_topic_ibfk_4')->references('priority_id')->on('ticket_priority')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('sla_plan', 'help_topic_ibfk_5')->references('id')->on('sla_plan')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('auto_assign', 'help_topic_ibfk_6')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('help_topic', function (Blueprint $table) {
            $table->dropForeign('help_topic_ibfk_1');
            $table->dropForeign('help_topic_ibfk_2');
            $table->dropForeign('help_topic_ibfk_3');
            $table->dropForeign('help_topic_ibfk_4');
            $table->dropForeign('help_topic_ibfk_5');
            $table->dropForeign('help_topic_ibfk_6');
        });
    }
};
