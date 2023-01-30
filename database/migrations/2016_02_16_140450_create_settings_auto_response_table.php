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
        Schema::create('settings_auto_response', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('new_ticket')->default(0);
            $table->boolean('agent_new_ticket')->default(0);
            $table->boolean('submitter')->default(0);
            $table->boolean('participants')->default(0);
            $table->boolean('overlimit')->default(0);
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
        Schema::drop('settings_auto_response');
    }
};
