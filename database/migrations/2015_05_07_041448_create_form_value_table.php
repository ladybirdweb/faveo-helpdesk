<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFormValueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('form_value', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('form_id');
			$table->integer('user_id');
			$table->string('name');
			$table->string('values');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('form_value');
	}

}
