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
        if (!Schema::hasColumn('ticket_source', 'css_class')) {
            Schema::table(
                'ticket_source',
                function (Blueprint $table) {
                    $table->string('css_class');
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_source', function (Blueprint $table) {
            //
        });
    }
};
