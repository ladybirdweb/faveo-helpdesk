<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccessTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('access', function (Blueprint $table) {
			$table->increments('id');
			$table->string('password_expire');
			$table->string('reg_method');
			$table->string('user_session');
			$table->string('agent_session');
			$table->string('reset_ticket_expire');
			$table->boolean('password_reset');
			$table->boolean('bind_agent_ip');
			$table->boolean('reg_require');
			$table->boolean('quick_access');
			$table->timestamps();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::create('access');
	}

}
