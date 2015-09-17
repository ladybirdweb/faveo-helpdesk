<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAutoResponseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('auto_response', function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('new_ticket');
			$table->boolean('agent_new_ticket');
			$table->boolean('submitter');
			$table->boolean('participants');
			$table->boolean('overlimit');
			$table->timestamps();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('auto_response');
	}

}
