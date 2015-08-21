<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('system', function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('status');
			$table->string('url');
			$table->string('name');
			$table->string('department');
			$table->string('page_size');
			$table->string('log_level');
			$table->string('purge_log');
			$table->string('name_format');
			$table->string('time_farmat');
			$table->string('date_format');
			$table->string('date_time_format');
			$table->string('day_date_time');
			$table->string('time_zone');
			$table->string('content');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('system');
	}

}
