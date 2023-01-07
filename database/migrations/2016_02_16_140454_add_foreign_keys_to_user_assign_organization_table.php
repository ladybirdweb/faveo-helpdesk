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
        Schema::table('user_assign_organization', function (Blueprint $table) {
            $table->foreign('org_id', 'user_assign_organization_ibfk_1')->references('id')->on('organization')->onUpdate('NO ACTION')->onDelete('RESTRICT');
            $table->foreign('user_id', 'user_assign_organization_ibfk_2')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_assign_organization', function (Blueprint $table) {
            $table->dropForeign('user_assign_organization_ibfk_1');
            $table->dropForeign('user_assign_organization_ibfk_2');
        });
    }
};
