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
        Schema::table('team_assign_agent', function (Blueprint $table) {
            $table->foreign('team_id', 'team_assign_agent_ibfk_1')->references('id')->on('teams')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('agent_id', 'team_assign_agent_ibfk_2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('team_assign_agent', function (Blueprint $table) {
            $table->dropForeign('team_assign_agent_ibfk_1');
            $table->dropForeign('team_assign_agent_ibfk_2');
        });
    }
};
