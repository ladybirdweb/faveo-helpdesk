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
        Schema::table('ticket_attachment', function (Blueprint $table) {
            $table->foreign('thread_id', 'ticket_attachment_ibfk_1')->references('id')->on('ticket_thread')->onUpdate('NO ACTION')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_attachment', function (Blueprint $table) {
            $table->dropForeign('ticket_attachment_ibfk_1');
        });
    }
};
