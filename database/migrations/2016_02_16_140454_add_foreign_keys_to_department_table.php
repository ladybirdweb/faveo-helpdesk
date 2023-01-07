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
        Schema::table('department', function (Blueprint $table) {
            $table->foreign('sla', 'department_ibfk_1')->references('id')->on('sla_plan')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('manager', 'department_ibfk_2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('department', function (Blueprint $table) {
            $table->dropForeign('department_ibfk_1');
            $table->dropForeign('department_ibfk_2');
        });
    }
};
