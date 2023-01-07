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
        Schema::create('workflow_action', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workflow_id')->unsigned();
            $table->string('condition');
            $table->string('action');
            $table->timestamps();
        });
        Schema::table('workflow_action', function (Blueprint $table) {
            $table->foreign('workflow_id', 'workflow_action_1')->references('id')->on('workflow_name')->onUpdate('NO ACTION')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('workflow_action');
        Schema::table('workflow_action', function (Blueprint $table) {
            $table->dropForeign('workflow_action_idfk_1');
        });
    }
};
