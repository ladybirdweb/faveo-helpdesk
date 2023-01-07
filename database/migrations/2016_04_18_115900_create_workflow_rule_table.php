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
        Schema::create('workflow_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workflow_id')->unsigned();
            $table->string('matching_criteria');
            $table->string('matching_scenario');
            $table->string('matching_relation');
            $table->text('matching_value');
            $table->timestamps();
        });

        Schema::table('workflow_rules', function (Blueprint $table) {
            $table->foreign('workflow_id', 'workflow_rules_1')->references('id')->on('workflow_name')->onUpdate('NO ACTION')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workflow_rules', function (Blueprint $table) {
            $table->dropForeign('workflow_rules_1');
        });
        Schema::drop('workflow_rules');
    }
};
