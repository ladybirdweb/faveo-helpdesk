<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tickets', function (Blueprint $table) {
			$table->increments('id');
			$table->string('ticket_number');
			$table->integer('user_id');
			$table->integer('dept_id');
			$table->integer('sla_id');
			$table->integer('staff_id');
			$table->integer('team_id');
			$table->integer('priority_id');
			$table->integer('sla');
			$table->integer('help_topic_id');
			$table->integer('status');
			$table->integer('flags');
			$table->integer('ip_address');
			$table->integer('assigned_to');
			$table->integer('lock_by');
			$table->integer('lock_at');
			$table->integer('source');
			$table->integer('isoverdue');
			$table->date('duedate');
			$table->integer('reopened');
			$table->integer('isanswered');
			$table->integer('html');
			$table->integer('is_deleted');
			$table->integer('closed');
			$table->string('last_message');
			$table->string('last_response');
			$table->dateTime('reopened_at');
			$table->dateTime('closed_at');
			$table->dateTime('last_message_at');
			$table->dateTime('last_response_at');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('tickets');
	}

}
