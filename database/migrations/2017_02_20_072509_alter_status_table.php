<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_status', function (Blueprint $table) {
            $table->boolean('visibility_for_client');
            $table->boolean('allow_client');
            $table->boolean('visibility_for_agent');
            $table->integer('purpose_of_status');
            $table->integer('secondary_status')->nullable();
            $table->integer('send_email');
            $table->integer('halt_sla');
            $table->integer('order');
            $table->string('icon');
            $table->string('icon_color');
            $table->integer('default')->nullable();
            $table->dropColumn('state');
            $table->dropColumn('mode');
            $table->dropColumn('flags');
            $table->dropColumn('sort');
            $table->dropColumn('email_user');
            $table->dropColumn('icon_class');
            $table->dropColumn('properties');
             });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
