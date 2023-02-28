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
        Schema::create('help_topic', function (Blueprint $table) {
            $table->increments('id');
            $table->string('topic');
            $table->string('parent_topic')->nullable();
            $table->integer('custom_form')->unsigned()->nullable()->index('custom_form');
            $table->integer('department')->unsigned()->nullable()->index('department');
            $table->integer('ticket_status')->unsigned()->nullable()->index('ticket_status');
            $table->integer('priority')->unsigned()->nullable()->index('priority');
            $table->integer('sla_plan')->unsigned()->nullable()->index('sla_plan');
            $table->string('thank_page')->nullable();
            $table->string('ticket_num_format');
            $table->string('internal_notes')->nullable();
            $table->boolean('status');
            $table->boolean('type');
            $table->integer('auto_assign')->unsigned()->nullable()->index('auto_assign_2');
            $table->boolean('auto_response');
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
        Schema::drop('help_topic');
    }
};
