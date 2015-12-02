<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('category', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('slug');
			$table->mediumText('description');
			$table->boolean('status');
			$table->integer('parent');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('categories');
	}

}
