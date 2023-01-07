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
        Schema::table('ticket_form_data', function (Blueprint $table) {
            $table->foreign('ticket_id', 'ticket_form_data_ibfk_1')->references('id')->on('tickets')->onUpdate('NO ACTION')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_form_data', function (Blueprint $table) {
            $table->dropForeign('ticket_form_data_ibfk_1');
        });
    }
};
