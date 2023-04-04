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
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('group_status');
            $table->boolean('can_create_ticket');
            $table->boolean('can_edit_ticket');
            $table->boolean('can_post_ticket');
            $table->boolean('can_close_ticket');
            $table->boolean('can_assign_ticket');
            $table->boolean('can_transfer_ticket');
            $table->boolean('can_delete_ticket');
            $table->boolean('can_ban_email');
            $table->boolean('can_manage_canned');
            $table->boolean('can_manage_faq')->default(0);
            $table->boolean('can_view_agent_stats');
            $table->boolean('department_access');
            $table->string('admin_notes')->nullable();
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
        Schema::drop('groups');
    }
};
