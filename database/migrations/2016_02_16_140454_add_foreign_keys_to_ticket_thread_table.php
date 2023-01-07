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
        Schema::table('ticket_thread', function (Blueprint $table) {
            $table->foreign('ticket_id', 'ticket_thread_ibfk_1')->references('id')->on('tickets')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('user_id', 'ticket_thread_ibfk_2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('source', 'ticket_thread_ibfk_3')->references('id')->on('ticket_source')->onUpdate('NO ACTION')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_thread', function (Blueprint $table) {
            $table->dropForeign('ticket_thread_ibfk_1');
            $table->dropForeign('ticket_thread_ibfk_2');
            $table->dropForeign('ticket_thread_ibfk_3');
        });
    }
};
