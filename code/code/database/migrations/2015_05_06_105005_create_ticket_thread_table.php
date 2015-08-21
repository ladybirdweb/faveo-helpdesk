<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketThreadTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('ticket_thread', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('pid');
			$table->integer('ticket_id');
			$table->integer('staff_id');
			$table->integer('user_id');
			$table->string('poster');
			$table->string('source');
			$table->boolean('is_internal');
			$table->string('title');
			$table->mediumText('body');
			$table->string('format');
			$table->string('ip_address');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('ticket_thread');
	}

}
