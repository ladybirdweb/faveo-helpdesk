<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('settings', function (Blueprint $table) {
			$table->increments('id');
			$table->string('company_name');
			$table->string('phone');
			$table->string('website');
			$table->string('address');
			$table->string('logo');
			$table->string('background');
			$table->string('version');
			$table->string('port');
			$table->string('host');
			$table->string('encryption');
			$table->string('email');
			$table->string('password');
			$table->integer('pagination');
			$table->string('timezone');
			$table->string('dateformat');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('settings');
	}

}
