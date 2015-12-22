<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('user_name');
			$table->string('first_name');
			$table->string('last_name');
			$table->boolean('gender');
			$table->string('email')->unique();
			$table->boolean('ban');
			$table->string('password', 60);
			$table->integer('active');
			$table->string('ext');
			$table->string('phone_number');
			$table->string('mobile');
			$table->string('agent_sign');
			$table->string('account_type');
			$table->string('account_status');
			$table->string('assign_group');
			$table->string('primary_dpt');
			$table->string('agent_tzone');
			$table->string('daylight_save');
			$table->string('limit_access');
			$table->string('directory_listing');
			$table->string('vocation_mode');
			$table->string('company');
			$table->string('role');
			$table->string('internal_note');
			$table->string('profile_pic');
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('users');
	}

}
