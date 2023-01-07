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
        Schema::create('group_assign_department', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned()->index('group_id');
            $table->integer('department_id')->unsigned()->index('department_id');
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
        Schema::drop('group_assign_department');
    }
};
