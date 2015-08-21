<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('emails', function (Blueprint $table) {
			$table->increments('id');
			$table->string('email_address');
			$table->string('email_name');
			$table->string('department');
			$table->string('priority');
			$table->string('help_topic');
			$table->string('user_name');
			$table->string('password');
			$table->string('fetching_host');
			$table->string('fetching_port');
			$table->string('mailbox_protocol');
			$table->string('imap_config');
			$table->string('folder');
			$table->string('sending_host');
			$table->string('sending_port');
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
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('emails');
	}

}
