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
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email_address');
            $table->string('email_name');
            $table->integer('department')->unsigned()->nullable();
            $table->integer('priority')->unsigned()->nullable()->index('priority');
            $table->integer('help_topic')->unsigned()->nullable()->index('help_topic');
            $table->string('user_name');
            $table->string('password');
            $table->string('fetching_host');
            $table->string('fetching_port');
            $table->string('fetching_protocol');
            $table->string('fetching_encryption');
            $table->string('mailbox_protocol');
            $table->string('imap_config');
            $table->string('folder');
            $table->string('sending_host');
            $table->string('sending_port');
            $table->string('sending_protocol');
            $table->string('sending_encryption');
            $table->string('smtp_validate');
            $table->string('smtp_authentication');
            $table->string('internal_notes');
            $table->boolean('auto_response');
            $table->boolean('fetching_status');
            $table->boolean('move_to_folder');
            $table->boolean('delete_email');
            $table->boolean('do_nothing');
            $table->boolean('sending_status');
            $table->boolean('authentication');
            $table->boolean('header_spoofing');
            $table->timestamps();
            $table->index(['department', 'priority', 'help_topic'], 'department');
            $table->index(['department', 'priority', 'help_topic'], 'department_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('emails');
    }
};
