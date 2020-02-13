<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_attachment', function (Blueprint $table) {
            $table->string('driver');
            $table->string('path');
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
            $table->string('driver');
            $table->string('path');
        });
    }
}
